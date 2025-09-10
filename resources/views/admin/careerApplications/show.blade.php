@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.careerApplication.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.career-applications.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.careerApplication.fields.id') }}
                        </th>
                        <td>
                            {{ $careerApplication->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careerApplication.fields.name') }}
                        </th>
                        <td>
                            {{ $careerApplication->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careerApplication.fields.email') }}
                        </th>
                        <td>
                            {{ $careerApplication->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careerApplication.fields.phone') }}
                        </th>
                        <td>
                            {{ $careerApplication->phone }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careerApplication.fields.location') }}
                        </th>
                        <td>
                            {{ $careerApplication->location }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careerApplication.fields.experience') }}
                        </th>
                        <td>
                            {{ $careerApplication->experience }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careerApplication.fields.qualifications') }}
                        </th>
                        <td>
                            {{ $careerApplication->qualifications }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careerApplication.fields.resume') }}
                        </th>
                        <td>
                            @if($careerApplication->resume)
                                <a href="{{ $careerApplication->resume->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careerApplication.fields.message') }}
                        </th>
                        <td>
                            {!! $careerApplication->message !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careerApplication.fields.job_opening') }}
                        </th>
                        <td>
                            {{ $careerApplication->job_opening->designation ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.careerApplication.fields.created_at') }}
                        </th>
                        <td>
                            {{ $careerApplication->created_at }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.career-applications.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection