@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.blogCategory.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.blog-categories.update", [$blogCategory->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.blogCategory.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $blogCategory->name) }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.blogCategory.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="slug">{{ trans('cruds.blogCategory.fields.slug') }}</label>
                <input class="form-control {{ $errors->has('slug') ? 'is-invalid' : '' }}" type="text" name="slug" id="slug" value="{{ old('slug', $blogCategory->slug) }}" required>
                @if($errors->has('slug'))
                    <div class="invalid-feedback">
                        {{ $errors->first('slug') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.blogCategory.fields.slug_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="sequence">{{ trans('cruds.blogCategory.fields.sequence') }}</label>
                <input class="form-control {{ $errors->has('sequence') ? 'is-invalid' : '' }}" type="number" name="sequence" id="sequence" value="{{ old('sequence', $blogCategory->sequence) }}" step="1">
                @if($errors->has('sequence'))
                    <div class="invalid-feedback">
                        {{ $errors->first('sequence') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.blogCategory.fields.sequence_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('active') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="active" value="0">
                    <input class="form-check-input" type="checkbox" name="active" id="active" value="1" {{ $blogCategory->active || old('active', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="active">{{ trans('cruds.blogCategory.fields.active') }}</label>
                </div>
                @if($errors->has('active'))
                    <div class="invalid-feedback">
                        {{ $errors->first('active') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.blogCategory.fields.active_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="blog_category_id">{{ trans('cruds.blogCategory.fields.blog_category') }}</label>
                <select class="form-control select2 {{ $errors->has('blog_category') ? 'is-invalid' : '' }}" name="blog_category_id" id="blog_category_id">
                    @foreach($blog_categories as $id => $entry)
                        <option value="{{ $id }}" {{ (old('blog_category_id') ? old('blog_category_id') : $blogCategory->blog_category->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('blog_category'))
                    <div class="invalid-feedback">
                        {{ $errors->first('blog_category') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.blogCategory.fields.blog_category_helper') }}</span>
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