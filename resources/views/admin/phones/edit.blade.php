@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.phone.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.phones.update", [$phone->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="company_id">{{ trans('cruds.phone.fields.company') }}</label>
                <select class="form-control select2 {{ $errors->has('company') ? 'is-invalid' : '' }}" name="company_id" id="company_id" required>
                    @foreach($companies as $id => $entry)
                        <option value="{{ $id }}" {{ (old('company_id') ? old('company_id') : $phone->company->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('company'))
                    <div class="invalid-feedback">
                        {{ $errors->first('company') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.phone.fields.company_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="number">{{ trans('cruds.phone.fields.number') }}</label>
                <input class="form-control {{ $errors->has('number') ? 'is-invalid' : '' }}" type="text" name="number" id="number" value="{{ old('number', $phone->number) }}" required>
                @if($errors->has('number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('number') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.phone.fields.number_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('whatsapp') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="whatsapp" value="0">
                    <input class="form-check-input" type="checkbox" name="whatsapp" id="whatsapp" value="1" {{ $phone->whatsapp || old('whatsapp', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="whatsapp">{{ trans('cruds.phone.fields.whatsapp') }}</label>
                </div>
                @if($errors->has('whatsapp'))
                    <div class="invalid-feedback">
                        {{ $errors->first('whatsapp') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.phone.fields.whatsapp_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="sequence">{{ trans('cruds.phone.fields.sequence') }}</label>
                <input class="form-control {{ $errors->has('sequence') ? 'is-invalid' : '' }}" type="number" name="sequence" id="sequence" value="{{ old('sequence', $phone->sequence) }}" step="1">
                @if($errors->has('sequence'))
                    <div class="invalid-feedback">
                        {{ $errors->first('sequence') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.phone.fields.sequence_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('active') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="active" value="0">
                    <input class="form-check-input" type="checkbox" name="active" id="active" value="1" {{ $phone->active || old('active', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="active">{{ trans('cruds.phone.fields.active') }}</label>
                </div>
                @if($errors->has('active'))
                    <div class="invalid-feedback">
                        {{ $errors->first('active') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.phone.fields.active_helper') }}</span>
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