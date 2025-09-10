@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.courseFaq.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.course-faqs.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.courseFaq.fields.id') }}
                        </th>
                        <td>
                            {{ $courseFaq->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.courseFaq.fields.course') }}
                        </th>
                        <td>
                            {{ $courseFaq->course->heading ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.courseFaq.fields.question') }}
                        </th>
                        <td>
                            {{ $courseFaq->question }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.courseFaq.fields.answer') }}
                        </th>
                        <td>
                            {{ $courseFaq->answer }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.courseFaq.fields.sequence') }}
                        </th>
                        <td>
                            {{ $courseFaq->sequence }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.courseFaq.fields.active') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $courseFaq->active ? 'checked' : '' }}>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.course-faqs.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection