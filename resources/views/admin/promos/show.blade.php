@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.promo.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.promos.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.promo.fields.id') }}
                        </th>
                        <td>
                            {{ $promo->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.promo.fields.code') }}
                        </th>
                        <td>
                            {{ $promo->code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.promo.fields.percentage') }}
                        </th>
                        <td>
                            {{ $promo->percentage }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.promos.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection