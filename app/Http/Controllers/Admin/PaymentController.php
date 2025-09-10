<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPaymentRequest;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Models\Order;
use App\Models\Payment;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('payment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Payment::with(['order'])->select(sprintf('%s.*', (new Payment)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'payment_show';
                $editGate      = 'payment_edit';
                $deleteGate    = 'payment_delete';
                $crudRoutePart = 'payments';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->addColumn('order_order_number', function ($row) {
                return $row->order ? $row->order->order_number : '';
            });

            $table->editColumn('payment', function ($row) {
                return $row->payment ? $row->payment : '';
            });
            // $table->editColumn('transaction', function ($row) {
            //     return $row->transaction ? $row->transaction : '';
            // });
            $table->editColumn('mode_of_payment', function ($row) {
                return $row->mode_of_payment ? Payment::MODE_OF_PAYMENT_SELECT[$row->mode_of_payment] : '';
            });
            $table->editColumn('amount', function ($row) {
                return $row->amount ? $row->amount : '';
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? Payment::STATUS_SELECT[$row->status] : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'order']);

            return $table->make(true);
        }

        $orders = Order::get();

        return view('admin.payments.index', compact('orders'));
    }

    public function create()
    {
        abort_if(Gate::denies('payment_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $orders = Order::pluck('order_number', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.payments.create', compact('orders'));
    }

    public function store(StorePaymentRequest $request)
    {
        $payment = Payment::create($request->all());

        return redirect()->route('admin.payments.index');
    }

    public function edit(Payment $payment)
    {
        abort_if(Gate::denies('payment_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $orders = Order::pluck('order_number', 'id')->prepend(trans('global.pleaseSelect'), '');

        $payment->load('order');

        return view('admin.payments.edit', compact('orders', 'payment'));
    }

    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        $payment->update($request->all());

        return redirect()->route('admin.payments.index');
    }

    public function show(Payment $payment)
    {
        abort_if(Gate::denies('payment_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $payment->load('order');

        return view('admin.payments.show', compact('payment'));
    }

    public function destroy(Payment $payment)
    {
        abort_if(Gate::denies('payment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $payment->delete();

        return back();
    }

    public function massDestroy(MassDestroyPaymentRequest $request)
    {
        $payments = Payment::find(request('ids'));

        foreach ($payments as $payment) {
            $payment->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
