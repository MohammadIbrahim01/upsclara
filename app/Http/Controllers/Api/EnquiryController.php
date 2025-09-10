<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EnquiryController extends Controller
{
    /**
     * Store a new enquiry
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20',
                'message' => 'required|string|max:2000',
            ]);

            $enquiry = Enquiry::create($validated);

            return response()->json([
                'message' => 'Enquiry submitted successfully',
                'enquiry' => [
                    'name' => $enquiry->name,
                    'email' => $enquiry->email,
                    'phone' => $enquiry->phone,
                    'message' => $enquiry->message,
                    'submitted_at' => $enquiry->created_at
                ]
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while submitting the enquiry'
            ], 500);
        }
    }
}
