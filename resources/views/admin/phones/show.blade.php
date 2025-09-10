@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.phone.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.phones.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.phone.fields.id') }}
                        </th>
                        <td>
                            {{ $phone->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.phone.fields.company') }}
                        </th>
                        <td>
                            {{ $phone->company->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.phone.fields.number') }}
                        </th>
                        <td>
                            {{ $phone->number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.phone.fields.whatsapp') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $phone->whatsapp ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.phone.fields.sequence') }}
                        </th>
                        <td>
                            {{ $phone->sequence }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.phone.fields.active') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $phone->active ? 'checked' : '' }}>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.phones.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection