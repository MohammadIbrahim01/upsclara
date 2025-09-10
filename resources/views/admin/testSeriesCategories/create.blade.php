@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.testSeriesCategory.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.test-series-categories.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.testSeriesCategory.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.testSeriesCategory.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="slug">{{ trans('cruds.testSeriesCategory.fields.slug') }}</label>
                <input class="form-control {{ $errors->has('slug') ? 'is-invalid' : '' }}" type="text" name="slug" id="slug" value="{{ old('slug', '') }}" required>
                @if($errors->has('slug'))
                    <div class="invalid-feedback">
                        {{ $errors->first('slug') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.testSeriesCategory.fields.slug_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="test_series_category_id">{{ trans('cruds.testSeriesCategory.fields.test_series_category') }}</label>
                <select class="form-control select2 {{ $errors->has('test_series_category') ? 'is-invalid' : '' }}" name="test_series_category_id" id="test_series_category_id">
                    @foreach($test_series_categories as $id => $entry)
                        <option value="{{ $id }}" {{ old('test_series_category_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('test_series_category'))
                    <div class="invalid-feedback">
                        {{ $errors->first('test_series_category') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.testSeriesCategory.fields.test_series_category_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="sequence">{{ trans('cruds.testSeriesCategory.fields.sequence') }}</label>
                <input class="form-control {{ $errors->has('sequence') ? 'is-invalid' : '' }}" type="number" name="sequence" id="sequence" value="{{ old('sequence', '1') }}" step="1">
                @if($errors->has('sequence'))
                    <div class="invalid-feedback">
                        {{ $errors->first('sequence') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.testSeriesCategory.fields.sequence_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('active') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="active" value="0">
                    <input class="form-check-input" type="checkbox" name="active" id="active" value="1" {{ old('active', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="active">{{ trans('cruds.testSeriesCategory.fields.active') }}</label>
                </div>
                @if($errors->has('active'))
                    <div class="invalid-feedback">
                        {{ $errors->first('active') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.testSeriesCategory.fields.active_helper') }}</span>
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