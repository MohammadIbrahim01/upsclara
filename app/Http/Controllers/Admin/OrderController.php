<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyOrderRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Course;
use App\Models\Order;
use App\Models\TestSeries;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('order_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Order::with(['courses', 'test_series'])->select(sprintf('%s.*', (new Order)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'order_show';
                $editGate      = 'order_edit';
                $deleteGate    = 'order_delete';
                $crudRoutePart = 'orders';

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
            $table->editColumn('order_number', function ($row) {
                return $row->order_number ? $row->order_number : '';
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : '';
            });
            $table->editColumn('phone', function ($row) {
                return $row->phone ? $row->phone : '';
            });
            $table->editColumn('address', function ($row) {
                return $row->address ? $row->address : '';
            });
            $table->editColumn('pin_code', function ($row) {
                return $row->pin_code ? $row->pin_code : '';
            });
            $table->editColumn('city', function ($row) {
                return $row->city ? $row->city : '';
            });
            $table->editColumn('state', function ($row) {
                return $row->state ? $row->state : '';
            });
            $table->editColumn('country', function ($row) {
                return $row->country ? $row->country : '';
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? Order::STATUS_SELECT[$row->status] : '';
            });
            $table->editColumn('course', function ($row) {
                $labels = [];
                foreach ($row->courses as $course) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $course->heading);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('test_series', function ($row) {
                $labels = [];
                foreach ($row->test_series as $test_series) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $test_series->heading);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('gross_amount', function ($row) {
                return $row->gross_amount ? $row->gross_amount : '';
            });
            $table->editColumn('discount_amount', function ($row) {
                return $row->discount_amount ? $row->discount_amount : '';
            });
            $table->editColumn('net_amount', function ($row) {
                return $row->net_amount ? $row->net_amount : '';
            });
            $table->editColumn('promo_code_applied', function ($row) {
                return $row->promo_code_applied ? $row->promo_code_applied : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'course', 'test_series']);

            return $table->make(true);
        }

        $courses      = Course::get();
        $test_seriess = TestSeries::get();

        return view('admin.orders.index', compact('courses', 'test_seriess'));
    }

    public function create()
    {
        abort_if(Gate::denies('order_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::pluck('heading', 'id');

        $test_series = TestSeries::pluck('heading', 'id');

        return view('admin.orders.create', compact('courses', 'test_series'));
    }

    public function store(StoreOrderRequest $request)
    {
        $order = Order::create($request->all());
        $order->courses()->sync($request->input('courses', []));
        $order->test_series()->sync($request->input('test_series', []));

        return redirect()->route('admin.orders.index');
    }

    public function edit(Order $order)
    {
        abort_if(Gate::denies('order_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::pluck('heading', 'id');

        $test_series = TestSeries::pluck('heading', 'id');

        $order->load('courses', 'test_series');

        return view('admin.orders.edit', compact('courses', 'order', 'test_series'));
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        $order->update($request->all());
        $order->courses()->sync($request->input('courses', []));
        $order->test_series()->sync($request->input('test_series', []));

        return redirect()->route('admin.orders.index');
    }

    public function show(Order $order)
    {
        abort_if(Gate::denies('order_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $order->load('courses', 'test_series');

        return view('admin.orders.show', compact('order'));
    }

    public function destroy(Order $order)
    {
        abort_if(Gate::denies('order_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $order->delete();

        return back();
    }

    public function massDestroy(MassDestroyOrderRequest $request)
    {
        $orders = Order::find(request('ids'));

        foreach ($orders as $order) {
            $order->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
