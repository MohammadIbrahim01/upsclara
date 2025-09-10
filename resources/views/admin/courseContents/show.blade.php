@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.courseContent.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.course-contents.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.courseContent.fields.id') }}
                        </th>
                        <td>
                            {{ $courseContent->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.courseContent.fields.title') }}
                        </th>
                        <td>
                            {{ $courseContent->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.courseContent.fields.content') }}
                        </th>
                        <td>
                            {{ $courseContent->content }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.courseContent.fields.course') }}
                        </th>
                        <td>
                            {{ $courseContent->course->heading ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.courseContent.fields.sequence') }}
                        </th>
                        <td>
                            {{ $courseContent->sequence }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.course-contents.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection