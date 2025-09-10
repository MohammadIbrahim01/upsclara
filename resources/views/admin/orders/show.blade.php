@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.order.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.orders.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.order.fields.id') }}
                        </th>
                        <td>
                            {{ $order->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.order.fields.order_number') }}
                        </th>
                        <td>
                            {{ $order->order_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.order.fields.name') }}
                        </th>
                        <td>
                            {{ $order->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.order.fields.email') }}
                        </th>
                        <td>
                            {{ $order->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.order.fields.phone') }}
                        </th>
                        <td>
                            {{ $order->phone }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.order.fields.address') }}
                        </th>
                        <td>
                            {{ $order->address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.order.fields.pin_code') }}
                        </th>
                        <td>
                            {{ $order->pin_code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.order.fields.city') }}
                        </th>
                        <td>
                            {{ $order->city }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.order.fields.state') }}
                        </th>
                        <td>
                            {{ $order->state }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.order.fields.country') }}
                        </th>
                        <td>
                            {{ $order->country }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.order.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\Order::STATUS_SELECT[$order->status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.order.fields.course') }}
                        </th>
                        <td>
                            @foreach($order->courses as $key => $course)
                                <span class="label label-info">{{ $course->heading }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.order.fields.test_series') }}
                        </th>
                        <td>
                            @foreach($order->test_series as $key => $test_series)
                                <span class="label label-info">{{ $test_series->heading }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.order.fields.gross_amount') }}
                        </th>
                        <td>
                            {{ $order->gross_amount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.order.fields.discount_amount') }}
                        </th>
                        <td>
                            {{ $order->discount_amount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.order.fields.net_amount') }}
                        </th>
                        <td>
                            {{ $order->net_amount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.order.fields.promo_code_applied') }}
                        </th>
                        <td>
                            {{ $order->promo_code_applied }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.order.fields.created_at') }}
                        </th>
                        <td>
                            {{ $order->created_at }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.orders.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection