@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.blogCategory.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.blog-categories.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.blogCategory.fields.id') }}
                        </th>
                        <td>
                            {{ $blogCategory->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.blogCategory.fields.name') }}
                        </th>
                        <td>
                            {{ $blogCategory->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.blogCategory.fields.slug') }}
                        </th>
                        <td>
                            {{ $blogCategory->slug }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.blogCategory.fields.sequence') }}
                        </th>
                        <td>
                            {{ $blogCategory->sequence }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.blogCategory.fields.active') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $blogCategory->active ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.blogCategory.fields.blog_category') }}
                        </th>
                        <td>
                            {{ $blogCategory->blog_category->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.blog-categories.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection