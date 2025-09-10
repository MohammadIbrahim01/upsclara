@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.jobOpening.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.job-openings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.jobOpening.fields.id') }}
                        </th>
                        <td>
                            {{ $jobOpening->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.jobOpening.fields.designation') }}
                        </th>
                        <td>
                            {{ $jobOpening->designation }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.jobOpening.fields.location') }}
                        </th>
                        <td>
                            {{ $jobOpening->location }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.jobOpening.fields.content') }}
                        </th>
                        <td>
                            {!! $jobOpening->content !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.jobOpening.fields.sequence') }}
                        </th>
                        <td>
                            {{ $jobOpening->sequence }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.jobOpening.fields.active') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $jobOpening->active ? 'checked' : '' }}>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.job-openings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection