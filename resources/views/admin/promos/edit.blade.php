@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.promo.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.promos.update", [$promo->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="code">{{ trans('cruds.promo.fields.code') }}</label>
                <input class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}" type="text" name="code" id="code" value="{{ old('code', $promo->code) }}" required>
                @if($errors->has('code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.promo.fields.code_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="percentage">{{ trans('cruds.promo.fields.percentage') }}</label>
                <input class="form-control {{ $errors->has('percentage') ? 'is-invalid' : '' }}" type="number" name="percentage" id="percentage" value="{{ old('percentage', $promo->percentage) }}" step="1" required>
                @if($errors->has('percentage'))
                    <div class="invalid-feedback">
                        {{ $errors->first('percentage') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.promo.fields.percentage_helper') }}</span>
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