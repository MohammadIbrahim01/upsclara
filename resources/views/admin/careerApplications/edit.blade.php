@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.careerApplication.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.career-applications.update", [$careerApplication->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="name">{{ trans('cruds.careerApplication.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $careerApplication->name) }}">
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.careerApplication.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="email">{{ trans('cruds.careerApplication.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email', $careerApplication->email) }}">
                @if($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.careerApplication.fields.email_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="phone">{{ trans('cruds.careerApplication.fields.phone') }}</label>
                <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('phone', $careerApplication->phone) }}">
                @if($errors->has('phone'))
                    <div class="invalid-feedback">
                        {{ $errors->first('phone') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.careerApplication.fields.phone_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="location">{{ trans('cruds.careerApplication.fields.location') }}</label>
                <input class="form-control {{ $errors->has('location') ? 'is-invalid' : '' }}" type="text" name="location" id="location" value="{{ old('location', $careerApplication->location) }}">
                @if($errors->has('location'))
                    <div class="invalid-feedback">
                        {{ $errors->first('location') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.careerApplication.fields.location_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="experience">{{ trans('cruds.careerApplication.fields.experience') }}</label>
                <input class="form-control {{ $errors->has('experience') ? 'is-invalid' : '' }}" type="text" name="experience" id="experience" value="{{ old('experience', $careerApplication->experience) }}">
                @if($errors->has('experience'))
                    <div class="invalid-feedback">
                        {{ $errors->first('experience') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.careerApplication.fields.experience_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="qualifications">{{ trans('cruds.careerApplication.fields.qualifications') }}</label>
                <textarea class="form-control {{ $errors->has('qualifications') ? 'is-invalid' : '' }}" name="qualifications" id="qualifications">{{ old('qualifications', $careerApplication->qualifications) }}</textarea>
                @if($errors->has('qualifications'))
                    <div class="invalid-feedback">
                        {{ $errors->first('qualifications') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.careerApplication.fields.qualifications_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="resume">{{ trans('cruds.careerApplication.fields.resume') }}</label>
                <div class="needsclick dropzone {{ $errors->has('resume') ? 'is-invalid' : '' }}" id="resume-dropzone">
                </div>
                @if($errors->has('resume'))
                    <div class="invalid-feedback">
                        {{ $errors->first('resume') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.careerApplication.fields.resume_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="message">{{ trans('cruds.careerApplication.fields.message') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('message') ? 'is-invalid' : '' }}" name="message" id="message">{!! old('message', $careerApplication->message) !!}</textarea>
                @if($errors->has('message'))
                    <div class="invalid-feedback">
                        {{ $errors->first('message') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.careerApplication.fields.message_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="job_opening_id">{{ trans('cruds.careerApplication.fields.job_opening') }}</label>
                <select class="form-control select2 {{ $errors->has('job_opening') ? 'is-invalid' : '' }}" name="job_opening_id" id="job_opening_id">
                    @foreach($job_openings as $id => $entry)
                        <option value="{{ $id }}" {{ (old('job_opening_id') ? old('job_opening_id') : $careerApplication->job_opening->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('job_opening'))
                    <div class="invalid-feedback">
                        {{ $errors->first('job_opening') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.careerApplication.fields.job_opening_helper') }}</span>
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
    Dropzone.options.resumeDropzone = {
    url: '{{ route('admin.career-applications.storeMedia') }}',
    maxFilesize: 10, // MB
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 10
    },
    success: function (file, response) {
      $('form').find('input[name="resume"]').remove()
      $('form').append('<input type="hidden" name="resume" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="resume"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($careerApplication) && $careerApplication->resume)
      var file = {!! json_encode($careerApplication->resume) !!}
          this.options.addedfile.call(this, file)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="resume" value="' + file.file_name + '">')
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
<script>
    $(document).ready(function () {
  function SimpleUploadAdapter(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
      return {
        upload: function() {
          return loader.file
            .then(function (file) {
              return new Promise(function(resolve, reject) {
                // Init request
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ route('admin.career-applications.storeCKEditorImages') }}', true);
                xhr.setRequestHeader('x-csrf-token', window._token);
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.responseType = 'json';

                // Init listeners
                var genericErrorText = `Couldn't upload file: ${ file.name }.`;
                xhr.addEventListener('error', function() { reject(genericErrorText) });
                xhr.addEventListener('abort', function() { reject() });
                xhr.addEventListener('load', function() {
                  var response = xhr.response;

                  if (!response || xhr.status !== 201) {
                    return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
                  }

                  $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');

                  resolve({ default: response.url });
                });

                if (xhr.upload) {
                  xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                      loader.uploadTotal = e.total;
                      loader.uploaded = e.loaded;
                    }
                  });
                }

                // Send request
                var data = new FormData();
                data.append('upload', file);
                data.append('crud_id', '{{ $careerApplication->id ?? 0 }}');
                xhr.send(data);
              });
            })
        }
      };
    }
  }

  var allEditors = document.querySelectorAll('.ckeditor');
  for (var i = 0; i < allEditors.length; ++i) {
    ClassicEditor.create(
      allEditors[i], {
        extraPlugins: [SimpleUploadAdapter]
      }
    );
  }
});
</script>

@endsection