@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.faculty.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.faculties.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.faculty.fields.id') }}
                        </th>
                        <td>
                            {{ $faculty->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.faculty.fields.name') }}
                        </th>
                        <td>
                            {{ $faculty->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.faculty.fields.slug') }}
                        </th>
                        <td>
                            {{ $faculty->slug }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.faculty.fields.designation') }}
                        </th>
                        <td>
                            {{ $faculty->designation }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.faculty.fields.experience') }}
                        </th>
                        <td>
                            {{ $faculty->experience }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.faculty.fields.qualifications') }}
                        </th>
                        <td>
                            {{ $faculty->qualifications }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.faculty.fields.specialization') }}
                        </th>
                        <td>
                            {{ $faculty->specialization }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.faculty.fields.short_description') }}
                        </th>
                        <td>
                            {{ $faculty->short_description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.faculty.fields.long_description') }}
                        </th>
                        <td>
                            {{ $faculty->long_description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.faculty.fields.featured_image') }}
                        </th>
                        <td>
                            @if($faculty->featured_image)
                                <a href="{{ $faculty->featured_image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $faculty->featured_image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.faculty.fields.facebook_link') }}
                        </th>
                        <td>
                            {{ $faculty->facebook_link }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.faculty.fields.instagram_link') }}
                        </th>
                        <td>
                            {{ $faculty->instagram_link }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.faculty.fields.twitter_link') }}
                        </th>
                        <td>
                            {{ $faculty->twitter_link }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.faculty.fields.linkedin_link') }}
                        </th>
                        <td>
                            {{ $faculty->linkedin_link }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.faculty.fields.youtube_link') }}
                        </th>
                        <td>
                            {{ $faculty->youtube_link }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.faculty.fields.course') }}
                        </th>
                        <td>
                            @foreach($faculty->courses as $key => $course)
                                <span class="label label-info">{{ $course->heading }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.faculty.fields.test_series') }}
                        </th>
                        <td>
                            @foreach($faculty->test_series as $key => $test_series)
                                <span class="label label-info">{{ $test_series->heading }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.faculty.fields.sequence') }}
                        </th>
                        <td>
                            {{ $faculty->sequence }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.faculty.fields.active') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $faculty->active ? 'checked' : '' }}>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.faculties.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
