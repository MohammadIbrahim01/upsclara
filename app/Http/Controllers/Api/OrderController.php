<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Order;
use App\Models\Payment;
use App\Models\TestSeries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Create a new order with courses and test series
     */
    public function createOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'pin_code' => 'required|string|max:10',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'course_slugs' => 'array',
            'course_slugs.*' => 'string|exists:courses,slug',
            'test_series_slugs' => 'array',
            'test_series_slugs.*' => 'string|exists:test_seriess,slug',
            'promo_code_applied' => 'nullable|string|max:50',
            'discount_amount' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Validate that at least one course or test series is provided
        $courseSlugsList = $request->get('course_slugs', []);
        $testSeriesSlugsList = $request->get('test_series_slugs', []);

        if (empty($courseSlugsList) && empty($testSeriesSlugsList)) {
            return response()->json([
                'success' => false,
                'message' => 'At least one course or test series must be selected'
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Get courses and test series by slugs
            $courses = Course::whereIn('slug', $courseSlugsList)->where('active', true)->get();
            $testSeries = TestSeries::whereIn('slug', $testSeriesSlugsList)->where('active', true)->get();

            // Validate all requested items exist and are active
            if (count($courses) !== count($courseSlugsList)) {
                return response()->json([
                    'success' => false,
                    'message' => 'One or more courses are not available'
                ], 422);
            }

            if (count($testSeries) !== count($testSeriesSlugsList)) {
                return response()->json([
                    'success' => false,
                    'message' => 'One or more test series are not available'
                ], 422);
            }

            // Calculate total amount
            $courseTotal = $courses->sum('price');
            $testSeriesTotal = $testSeries->sum('price');
            $grossAmount = $courseTotal + $testSeriesTotal;
            $discountAmount = $request->get('discount_amount', 0);
            $netAmount = $grossAmount - $discountAmount;

            // Validate net amount is positive
            if ($netAmount < 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid discount amount'
                ], 422);
            }

            // Create order
            $order = Order::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'pin_code' => $request->pin_code,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country,
                'status' => 'Pending',
                'gross_amount' => $grossAmount,
                'discount_amount' => $discountAmount,
                'net_amount' => $netAmount,
                'promo_code_applied' => $request->promo_code_applied,
            ]);

            // Generate unique order number
            $order->order_number = 'ONEAIM-' . str_pad($order->id, 6, '0', STR_PAD_LEFT);
            $order->save();

            // Attach courses and test series to order
            if (!$courses->isEmpty()) {
                $order->courses()->attach($courses->pluck('id'));
            }

            if (!$testSeries->isEmpty()) {
                $order->test_series()->attach($testSeries->pluck('id'));
            }

            // Create initial payment record
            $payment = Payment::create([
                'order_id' => $order->id,
                'amount' => $netAmount,
                'mode_of_payment' => 'Razorpay',
                'status' => 'Processing',
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order created successfully',
                'data' => [
                    'order' => [
                        'order_number' => $order->order_number,
                        'name' => $order->name,
                        'email' => $order->email,
                        'phone' => $order->phone,
                        'address' => $order->address,
                        'pin_code' => $order->pin_code,
                        'city' => $order->city,
                        'state' => $order->state,
                        'country' => $order->country,
                        'status' => $order->status,
                        'gross_amount' => $order->gross_amount,
                        'discount_amount' => $order->discount_amount,
                        'net_amount' => $order->net_amount,
                        'promo_code_applied' => $order->promo_code_applied,
                    ],
                    'courses' => $courses->map(function ($course) {
                        return [
                            'heading' => $course->heading,
                            'slug' => $course->slug
                        ];
                    }),
                    'test_series' => $testSeries->map(function ($series) {
                        return [
                            'heading' => $series->heading,
                            'slug' => $series->slug
                        ];
                    })
                ]
            ], 201);

        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => 'Failed to create order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update payment details after Razorpay response
     */
    public function updatePayment(Request $request, $orderNumber)
    {
        $validator = Validator::make($request->all(), [
            'payment_id' => 'required|string',
            'transaction_id' => 'required|string',
            'status' => 'required|in:Success,Cancelled,Refunded',
            'payment_signature' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Find order by order number
            $order = Order::where('order_number', $orderNumber)->first();

            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found'
                ], 404);
            }

            // Get the latest payment record for this order, or create one if it doesn't exist
            $payment = $order->payments()->latest()->first();

            if (!$payment) {
                // Create new payment record if none exists
                $payment = Payment::create([
                    'order_id' => $order->id,
                    'amount' => $order->net_amount,
                    'mode_of_payment' => 'Razorpay',
                    'status' => 'Processing',
                ]);
            }

            // Update payment details
            $payment->update([
                'payment' => $request->payment_id,
                'transaction' => $request->transaction_id,
                'status' => $request->status,
            ]);

            // Update order status based on payment status
            if ($request->status === 'Success') {
                $order->update(['status' => 'Complete']);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Payment updated successfully',
                'data' => [
                    'order' => [
                        'order_number' => $order->order_number,
                        'status' => $order->status,
                        'net_amount' => $order->net_amount
                    ],
                    'payment' => [
                        'payment_id' => $payment->payment,
                        'transaction_id' => $payment->transaction,
                        'status' => $payment->status,
                        'mode_of_payment' => $payment->mode_of_payment,
                        'amount' => $payment->amount
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => 'Failed to update payment',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
