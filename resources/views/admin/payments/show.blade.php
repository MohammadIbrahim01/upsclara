@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.payment.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.payments.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.payment.fields.id') }}
                        </th>
                        <td>
                            {{ $payment->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.payment.fields.order') }}
                        </th>
                        <td>
                            {{ $payment->order->order_number ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.payment.fields.payment') }}
                        </th>
                        <td>
                            {{ $payment->payment }}
                        </td>
                    </tr>
                    {{-- <tr>
                        <th>
                            {{ trans('cruds.payment.fields.transaction') }}
                        </th>
                        <td>
                            {{ $payment->transaction }}
                        </td>
                    </tr> --}}
                    <tr>
                        <th>
                            {{ trans('cruds.payment.fields.mode_of_payment') }}
                        </th>
                        <td>
                            {{ App\Models\Payment::MODE_OF_PAYMENT_SELECT[$payment->mode_of_payment] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.payment.fields.amount') }}
                        </th>
                        <td>
                            {{ $payment->amount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.payment.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\Payment::STATUS_SELECT[$payment->status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.payment.fields.created_at') }}
                        </th>
                        <td>
                            {{ $payment->created_at }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.payments.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
