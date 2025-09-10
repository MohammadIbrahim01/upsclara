@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.socialMedium.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.social-media.update", [$socialMedium->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="company_id">{{ trans('cruds.socialMedium.fields.company') }}</label>
                <select class="form-control select2 {{ $errors->has('company') ? 'is-invalid' : '' }}" name="company_id" id="company_id" required>
                    @foreach($companies as $id => $entry)
                        <option value="{{ $id }}" {{ (old('company_id') ? old('company_id') : $socialMedium->company->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('company'))
                    <div class="invalid-feedback">
                        {{ $errors->first('company') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.socialMedium.fields.company_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="facebook_link">{{ trans('cruds.socialMedium.fields.facebook_link') }}</label>
                <input class="form-control {{ $errors->has('facebook_link') ? 'is-invalid' : '' }}" type="text" name="facebook_link" id="facebook_link" value="{{ old('facebook_link', $socialMedium->facebook_link) }}">
                @if($errors->has('facebook_link'))
                    <div class="invalid-feedback">
                        {{ $errors->first('facebook_link') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.socialMedium.fields.facebook_link_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="instagram_link">{{ trans('cruds.socialMedium.fields.instagram_link') }}</label>
                <input class="form-control {{ $errors->has('instagram_link') ? 'is-invalid' : '' }}" type="text" name="instagram_link" id="instagram_link" value="{{ old('instagram_link', $socialMedium->instagram_link) }}">
                @if($errors->has('instagram_link'))
                    <div class="invalid-feedback">
                        {{ $errors->first('instagram_link') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.socialMedium.fields.instagram_link_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="twitter_link">{{ trans('cruds.socialMedium.fields.twitter_link') }}</label>
                <input class="form-control {{ $errors->has('twitter_link') ? 'is-invalid' : '' }}" type="text" name="twitter_link" id="twitter_link" value="{{ old('twitter_link', $socialMedium->twitter_link) }}">
                @if($errors->has('twitter_link'))
                    <div class="invalid-feedback">
                        {{ $errors->first('twitter_link') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.socialMedium.fields.twitter_link_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="linkedin_link">{{ trans('cruds.socialMedium.fields.linkedin_link') }}</label>
                <input class="form-control {{ $errors->has('linkedin_link') ? 'is-invalid' : '' }}" type="text" name="linkedin_link" id="linkedin_link" value="{{ old('linkedin_link', $socialMedium->linkedin_link) }}">
                @if($errors->has('linkedin_link'))
                    <div class="invalid-feedback">
                        {{ $errors->first('linkedin_link') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.socialMedium.fields.linkedin_link_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="youtube_link">{{ trans('cruds.socialMedium.fields.youtube_link') }}</label>
                <input class="form-control {{ $errors->has('youtube_link') ? 'is-invalid' : '' }}" type="text" name="youtube_link" id="youtube_link" value="{{ old('youtube_link', $socialMedium->youtube_link) }}">
                @if($errors->has('youtube_link'))
                    <div class="invalid-feedback">
                        {{ $errors->first('youtube_link') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.socialMedium.fields.youtube_link_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="google_link">{{ trans('cruds.socialMedium.fields.google_link') }}</label>
                <input class="form-control {{ $errors->has('google_link') ? 'is-invalid' : '' }}" type="text" name="google_link" id="google_link" value="{{ old('google_link', $socialMedium->google_link) }}">
                @if($errors->has('google_link'))
                    <div class="invalid-feedback">
                        {{ $errors->first('google_link') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.socialMedium.fields.google_link_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="snapchat_link">{{ trans('cruds.socialMedium.fields.snapchat_link') }}</label>
                <input class="form-control {{ $errors->has('snapchat_link') ? 'is-invalid' : '' }}" type="text" name="snapchat_link" id="snapchat_link" value="{{ old('snapchat_link', $socialMedium->snapchat_link) }}">
                @if($errors->has('snapchat_link'))
                    <div class="invalid-feedback">
                        {{ $errors->first('snapchat_link') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.socialMedium.fields.snapchat_link_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection