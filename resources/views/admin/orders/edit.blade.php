@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.order.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.orders.update", [$order->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="order_number">{{ trans('cruds.order.fields.order_number') }}</label>
                <input class="form-control {{ $errors->has('order_number') ? 'is-invalid' : '' }}" type="text" name="order_number" id="order_number" value="{{ old('order_number', $order->order_number) }}">
                @if($errors->has('order_number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('order_number') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.order_number_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="name">{{ trans('cruds.order.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $order->name) }}">
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="email">{{ trans('cruds.order.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email', $order->email) }}">
                @if($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.email_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="phone">{{ trans('cruds.order.fields.phone') }}</label>
                <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('phone', $order->phone) }}">
                @if($errors->has('phone'))
                    <div class="invalid-feedback">
                        {{ $errors->first('phone') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.phone_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="address">{{ trans('cruds.order.fields.address') }}</label>
                <textarea class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" name="address" id="address">{{ old('address', $order->address) }}</textarea>
                @if($errors->has('address'))
                    <div class="invalid-feedback">
                        {{ $errors->first('address') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.address_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="pin_code">{{ trans('cruds.order.fields.pin_code') }}</label>
                <input class="form-control {{ $errors->has('pin_code') ? 'is-invalid' : '' }}" type="text" name="pin_code" id="pin_code" value="{{ old('pin_code', $order->pin_code) }}">
                @if($errors->has('pin_code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('pin_code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.pin_code_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="city">{{ trans('cruds.order.fields.city') }}</label>
                <input class="form-control {{ $errors->has('city') ? 'is-invalid' : '' }}" type="text" name="city" id="city" value="{{ old('city', $order->city) }}">
                @if($errors->has('city'))
                    <div class="invalid-feedback">
                        {{ $errors->first('city') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.city_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="state">{{ trans('cruds.order.fields.state') }}</label>
                <input class="form-control {{ $errors->has('state') ? 'is-invalid' : '' }}" type="text" name="state" id="state" value="{{ old('state', $order->state) }}">
                @if($errors->has('state'))
                    <div class="invalid-feedback">
                        {{ $errors->first('state') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.state_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="country">{{ trans('cruds.order.fields.country') }}</label>
                <input class="form-control {{ $errors->has('country') ? 'is-invalid' : '' }}" type="text" name="country" id="country" value="{{ old('country', $order->country) }}">
                @if($errors->has('country'))
                    <div class="invalid-feedback">
                        {{ $errors->first('country') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.country_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.order.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Order::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $order->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="courses">{{ trans('cruds.order.fields.course') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('courses') ? 'is-invalid' : '' }}" name="courses[]" id="courses" multiple>
                    @foreach($courses as $id => $course)
                        <option value="{{ $id }}" {{ (in_array($id, old('courses', [])) || $order->courses->contains($id)) ? 'selected' : '' }}>{{ $course }}</option>
                    @endforeach
                </select>
                @if($errors->has('courses'))
                    <div class="invalid-feedback">
                        {{ $errors->first('courses') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.course_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="test_series">{{ trans('cruds.order.fields.test_series') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('test_series') ? 'is-invalid' : '' }}" name="test_series[]" id="test_series" multiple>
                    @foreach($test_series as $id => $test_series)
                        <option value="{{ $id }}" {{ (in_array($id, old('test_series', [])) || $order->test_series->contains($id)) ? 'selected' : '' }}>{{ $test_series }}</option>
                    @endforeach
                </select>
                @if($errors->has('test_series'))
                    <div class="invalid-feedback">
                        {{ $errors->first('test_series') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.test_series_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="gross_amount">{{ trans('cruds.order.fields.gross_amount') }}</label>
                <input class="form-control {{ $errors->has('gross_amount') ? 'is-invalid' : '' }}" type="number" name="gross_amount" id="gross_amount" value="{{ old('gross_amount', $order->gross_amount) }}" step="0.01">
                @if($errors->has('gross_amount'))
                    <div class="invalid-feedback">
                        {{ $errors->first('gross_amount') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.gross_amount_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="discount_amount">{{ trans('cruds.order.fields.discount_amount') }}</label>
                <input class="form-control {{ $errors->has('discount_amount') ? 'is-invalid' : '' }}" type="number" name="discount_amount" id="discount_amount" value="{{ old('discount_amount', $order->discount_amount) }}" step="0.01">
                @if($errors->has('discount_amount'))
                    <div class="invalid-feedback">
                        {{ $errors->first('discount_amount') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.discount_amount_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="net_amount">{{ trans('cruds.order.fields.net_amount') }}</label>
                <input class="form-control {{ $errors->has('net_amount') ? 'is-invalid' : '' }}" type="number" name="net_amount" id="net_amount" value="{{ old('net_amount', $order->net_amount) }}" step="0.01">
                @if($errors->has('net_amount'))
                    <div class="invalid-feedback">
                        {{ $errors->first('net_amount') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.net_amount_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="promo_code_applied">{{ trans('cruds.order.fields.promo_code_applied') }}</label>
                <input class="form-control {{ $errors->has('promo_code_applied') ? 'is-invalid' : '' }}" type="text" name="promo_code_applied" id="promo_code_applied" value="{{ old('promo_code_applied', $order->promo_code_applied) }}">
                @if($errors->has('promo_code_applied'))
                    <div class="invalid-feedback">
                        {{ $errors->first('promo_code_applied') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.promo_code_applied_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection