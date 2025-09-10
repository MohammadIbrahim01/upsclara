@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.blog.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.blogs.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.blog.fields.id') }}
                        </th>
                        <td>
                            {{ $blog->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.blog.fields.title') }}
                        </th>
                        <td>
                            {{ $blog->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.blog.fields.slug') }}
                        </th>
                        <td>
                            {{ $blog->slug }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.blog.fields.heading') }}
                        </th>
                        <td>
                            {{ $blog->heading }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.blog.fields.short_description') }}
                        </th>
                        <td>
                            {{ $blog->short_description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.blog.fields.content') }}
                        </th>
                        <td>
                            {!! $blog->content !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.blog.fields.featured_image') }}
                        </th>
                        <td>
                            @if($blog->featured_image)
                                <a href="{{ $blog->featured_image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $blog->featured_image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.blog.fields.featured_image_caption') }}
                        </th>
                        <td>
                            {{ $blog->featured_image_caption }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.blog.fields.type') }}
                        </th>
                        <td>
                            {{ App\Models\Blog::TYPE_RADIO[$blog->type] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.blog.fields.publish_date') }}
                        </th>
                        <td>
                            {{ $blog->publish_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.blog.fields.blog_category') }}
                        </th>
                        <td>
                            @foreach($blog->blog_categories as $key => $blog_category)
                                <span class="label label-info">{{ $blog_category->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.blog.fields.active') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $blog->active ? 'checked' : '' }}>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.blogs.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection