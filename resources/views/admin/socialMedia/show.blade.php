@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.socialMedium.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.social-media.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.socialMedium.fields.id') }}
                        </th>
                        <td>
                            {{ $socialMedium->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.socialMedium.fields.company') }}
                        </th>
                        <td>
                            {{ $socialMedium->company->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.socialMedium.fields.facebook_link') }}
                        </th>
                        <td>
                            {{ $socialMedium->facebook_link }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.socialMedium.fields.instagram_link') }}
                        </th>
                        <td>
                            {{ $socialMedium->instagram_link }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.socialMedium.fields.twitter_link') }}
                        </th>
                        <td>
                            {{ $socialMedium->twitter_link }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.socialMedium.fields.linkedin_link') }}
                        </th>
                        <td>
                            {{ $socialMedium->linkedin_link }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.socialMedium.fields.youtube_link') }}
                        </th>
                        <td>
                            {{ $socialMedium->youtube_link }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.socialMedium.fields.google_link') }}
                        </th>
                        <td>
                            {{ $socialMedium->google_link }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.socialMedium.fields.snapchat_link') }}
                        </th>
                        <td>
                            {{ $socialMedium->snapchat_link }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.social-media.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection