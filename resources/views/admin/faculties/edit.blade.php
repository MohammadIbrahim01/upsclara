@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.faculty.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.faculties.update", [$faculty->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.faculty.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $faculty->name) }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.faculty.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="slug">{{ trans('cruds.faculty.fields.slug') }}</label>
                <input class="form-control {{ $errors->has('slug') ? 'is-invalid' : '' }}" type="text" name="slug" id="slug" value="{{ old('slug', $faculty->slug) }}" required>
                @if($errors->has('slug'))
                    <div class="invalid-feedback">
                        {{ $errors->first('slug') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.faculty.fields.slug_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="designation">{{ trans('cruds.faculty.fields.designation') }}</label>
                <input class="form-control {{ $errors->has('designation') ? 'is-invalid' : '' }}" type="text" name="designation" id="designation" value="{{ old('designation', $faculty->designation) }}">
                @if($errors->has('designation'))
                    <div class="invalid-feedback">
                        {{ $errors->first('designation') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.faculty.fields.designation_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="experience">{{ trans('cruds.faculty.fields.experience') }}</label>
                <input class="form-control {{ $errors->has('experience') ? 'is-invalid' : '' }}" type="text" name="experience" id="experience" value="{{ old('experience', $faculty->experience) }}">
                @if($errors->has('experience'))
                    <div class="invalid-feedback">
                        {{ $errors->first('experience') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.faculty.fields.experience_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="qualifications">{{ trans('cruds.faculty.fields.qualifications') }}</label>
                <input class="form-control {{ $errors->has('qualifications') ? 'is-invalid' : '' }}" type="text" name="qualifications" id="qualifications" value="{{ old('qualifications', $faculty->qualifications) }}">
                @if($errors->has('qualifications'))
                    <div class="invalid-feedback">
                        {{ $errors->first('qualifications') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.faculty.fields.qualifications_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="specialization">{{ trans('cruds.faculty.fields.specialization') }}</label>
                <input class="form-control {{ $errors->has('specialization') ? 'is-invalid' : '' }}" type="text" name="specialization" id="specialization" value="{{ old('specialization', $faculty->specialization) }}">
                @if($errors->has('specialization'))
                    <div class="invalid-feedback">
                        {{ $errors->first('specialization') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.faculty.fields.specialization_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="short_description">{{ trans('cruds.faculty.fields.short_description') }}</label>
                <input class="form-control {{ $errors->has('short_description') ? 'is-invalid' : '' }}" type="text" name="short_description" id="short_description" value="{{ old('short_description', $faculty->short_description) }}">
                @if($errors->has('short_description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('short_description') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.faculty.fields.short_description_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="long_description">{{ trans('cruds.faculty.fields.long_description') }}</label>
                <textarea class="form-control {{ $errors->has('long_description') ? 'is-invalid' : '' }}" name="long_description" id="long_description">{{ old('long_description', $faculty->long_description) }}</textarea>
                @if($errors->has('long_description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('long_description') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.faculty.fields.long_description_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="featured_image">{{ trans('cruds.faculty.fields.featured_image') }}</label>
                <div class="needsclick dropzone {{ $errors->has('featured_image') ? 'is-invalid' : '' }}" id="featured_image-dropzone">
                </div>
                @if($errors->has('featured_image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('featured_image') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.faculty.fields.featured_image_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="facebook_link">{{ trans('cruds.faculty.fields.facebook_link') }}</label>
                <input class="form-control {{ $errors->has('facebook_link') ? 'is-invalid' : '' }}" type="text" name="facebook_link" id="facebook_link" value="{{ old('facebook_link', $faculty->facebook_link) }}">
                @if($errors->has('facebook_link'))
                    <div class="invalid-feedback">
                        {{ $errors->first('facebook_link') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.faculty.fields.facebook_link_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="instagram_link">{{ trans('cruds.faculty.fields.instagram_link') }}</label>
                <input class="form-control {{ $errors->has('instagram_link') ? 'is-invalid' : '' }}" type="text" name="instagram_link" id="instagram_link" value="{{ old('instagram_link', $faculty->instagram_link) }}">
                @if($errors->has('instagram_link'))
                    <div class="invalid-feedback">
                        {{ $errors->first('instagram_link') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.faculty.fields.instagram_link_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="twitter_link">{{ trans('cruds.faculty.fields.twitter_link') }}</label>
                <input class="form-control {{ $errors->has('twitter_link') ? 'is-invalid' : '' }}" type="text" name="twitter_link" id="twitter_link" value="{{ old('twitter_link', $faculty->twitter_link) }}">
                @if($errors->has('twitter_link'))
                    <div class="invalid-feedback">
                        {{ $errors->first('twitter_link') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.faculty.fields.twitter_link_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="linkedin_link">{{ trans('cruds.faculty.fields.linkedin_link') }}</label>
                <input class="form-control {{ $errors->has('linkedin_link') ? 'is-invalid' : '' }}" type="text" name="linkedin_link" id="linkedin_link" value="{{ old('linkedin_link', $faculty->linkedin_link) }}">
                @if($errors->has('linkedin_link'))
                    <div class="invalid-feedback">
                        {{ $errors->first('linkedin_link') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.faculty.fields.linkedin_link_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="youtube_link">{{ trans('cruds.faculty.fields.youtube_link') }}</label>
                <input class="form-control {{ $errors->has('youtube_link') ? 'is-invalid' : '' }}" type="text" name="youtube_link" id="youtube_link" value="{{ old('youtube_link', $faculty->youtube_link) }}">
                @if($errors->has('youtube_link'))
                    <div class="invalid-feedback">
                        {{ $errors->first('youtube_link') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.faculty.fields.youtube_link_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="courses">{{ trans('cruds.faculty.fields.course') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('courses') ? 'is-invalid' : '' }}" name="courses[]" id="courses" multiple>
                    @foreach($courses as $id => $course)
                        <option value="{{ $id }}" {{ (in_array($id, old('courses', [])) || $faculty->courses->contains($id)) ? 'selected' : '' }}>{{ $course }}</option>
                    @endforeach
                </select>
                @if($errors->has('courses'))
                    <div class="invalid-feedback">
                        {{ $errors->first('courses') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.faculty.fields.course_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="test_series">{{ trans('cruds.faculty.fields.test_series') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('test_series') ? 'is-invalid' : '' }}" name="test_series[]" id="test_series" multiple>
                    @foreach($test_series as $id => $test_series)
                        <option value="{{ $id }}" {{ (in_array($id, old('test_series', [])) || $faculty->test_series->contains($id)) ? 'selected' : '' }}>{{ $test_series }}</option>
                    @endforeach
                </select>
                @if($errors->has('test_series'))
                    <div class="invalid-feedback">
                        {{ $errors->first('test_series') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.faculty.fields.test_series_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="sequence">{{ trans('cruds.faculty.fields.sequence') }}</label>
                <input class="form-control {{ $errors->has('sequence') ? 'is-invalid' : '' }}" type="number" name="sequence" id="sequence" value="{{ old('sequence', $faculty->sequence) }}" step="1">
                @if($errors->has('sequence'))
                    <div class="invalid-feedback">
                        {{ $errors->first('sequence') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.faculty.fields.sequence_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('active') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="active" value="0">
                    <input class="form-check-input" type="checkbox" name="active" id="active" value="1" {{ $faculty->active || old('active', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="active">{{ trans('cruds.faculty.fields.active') }}</label>
                </div>
                @if($errors->has('active'))
                    <div class="invalid-feedback">
                        {{ $errors->first('active') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.faculty.fields.active_helper') }}</span>
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

@section('scripts')
<script>
    Dropzone.options.featuredImageDropzone = {
    url: '{{ route('admin.faculties.storeMedia') }}',
    maxFilesize: 5, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 5,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="featured_image"]').remove()
      $('form').append('<input type="hidden" name="featured_image" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="featured_image"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($faculty) && $faculty->featured_image)
      var file = {!! json_encode($faculty->featured_image) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="featured_image" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
    error: function (file, response) {
        if ($.type(response) === 'string') {
            var message = response //dropzone sends it's own error messages in string
        } else {
            var message = response.errors.file
        }
        file.previewElement.classList.add('dz-error')
        _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
        _results = []
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            node = _ref[_i]
            _results.push(node.textContent = message)
        }

        return _results
    }
}

</script>
@endsection
