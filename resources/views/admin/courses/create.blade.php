@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.course.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.courses.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="heading">{{ trans('cruds.course.fields.heading') }}</label>
                <input class="form-control {{ $errors->has('heading') ? 'is-invalid' : '' }}" type="text" name="heading" id="heading" value="{{ old('heading', '') }}" required>
                @if($errors->has('heading'))
                    <div class="invalid-feedback">
                        {{ $errors->first('heading') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.course.fields.heading_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="slug">{{ trans('cruds.course.fields.slug') }}</label>
                <input class="form-control {{ $errors->has('slug') ? 'is-invalid' : '' }}" type="text" name="slug" id="slug" value="{{ old('slug', '') }}" required>
                @if($errors->has('slug'))
                    <div class="invalid-feedback">
                        {{ $errors->first('slug') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.course.fields.slug_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="sub_heading">{{ trans('cruds.course.fields.sub_heading') }}</label>
                <input class="form-control {{ $errors->has('sub_heading') ? 'is-invalid' : '' }}" type="text" name="sub_heading" id="sub_heading" value="{{ old('sub_heading', '') }}">
                @if($errors->has('sub_heading'))
                    <div class="invalid-feedback">
                        {{ $errors->first('sub_heading') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.course.fields.sub_heading_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.course.fields.language') }}</label>
                <select class="form-control {{ $errors->has('language') ? 'is-invalid' : '' }}" name="language" id="language">
                    <option value disabled {{ old('language', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Course::LANGUAGE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('language', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('language'))
                    <div class="invalid-feedback">
                        {{ $errors->first('language') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.course.fields.language_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="duration">{{ trans('cruds.course.fields.duration') }}</label>
                <input class="form-control {{ $errors->has('duration') ? 'is-invalid' : '' }}" type="text" name="duration" id="duration" value="{{ old('duration', '') }}">
                @if($errors->has('duration'))
                    <div class="invalid-feedback">
                        {{ $errors->first('duration') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.course.fields.duration_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="video_lectures">{{ trans('cruds.course.fields.video_lectures') }}</label>
                <input class="form-control {{ $errors->has('video_lectures') ? 'is-invalid' : '' }}" type="text" name="video_lectures" id="video_lectures" value="{{ old('video_lectures', '') }}">
                @if($errors->has('video_lectures'))
                    <div class="invalid-feedback">
                        {{ $errors->first('video_lectures') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.course.fields.video_lectures_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="questions_count">{{ trans('cruds.course.fields.questions_count') }}</label>
                <input class="form-control {{ $errors->has('questions_count') ? 'is-invalid' : '' }}" type="text" name="questions_count" id="questions_count" value="{{ old('questions_count', '') }}">
                @if($errors->has('questions_count'))
                    <div class="invalid-feedback">
                        {{ $errors->first('questions_count') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.course.fields.questions_count_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="enrolment_deadline_date">{{ trans('cruds.course.fields.enrolment_deadline_date') }}</label>
                <input class="form-control datetime {{ $errors->has('enrolment_deadline_date') ? 'is-invalid' : '' }}" type="text" name="enrolment_deadline_date" id="enrolment_deadline_date" value="{{ old('enrolment_deadline_date') }}">
                @if($errors->has('enrolment_deadline_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('enrolment_deadline_date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.course.fields.enrolment_deadline_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="price">{{ trans('cruds.course.fields.price') }}</label>
                <input class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" type="number" name="price" id="price" value="{{ old('price', '') }}" step="1">
                @if($errors->has('price'))
                    <div class="invalid-feedback">
                        {{ $errors->first('price') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.course.fields.price_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="short_description">{{ trans('cruds.course.fields.short_description') }}</label>
                <textarea class="form-control {{ $errors->has('short_description') ? 'is-invalid' : '' }}" name="short_description" id="short_description">{{ old('short_description') }}</textarea>
                @if($errors->has('short_description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('short_description') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.course.fields.short_description_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="long_description">{{ trans('cruds.course.fields.long_description') }}</label>
                <textarea class="form-control {{ $errors->has('long_description') ? 'is-invalid' : '' }}" name="long_description" id="long_description">{{ old('long_description') }}</textarea>
                @if($errors->has('long_description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('long_description') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.course.fields.long_description_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="content">{{ trans('cruds.course.fields.content') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('content') ? 'is-invalid' : '' }}" name="content" id="content">{!! old('content') !!}</textarea>
                @if($errors->has('content'))
                    <div class="invalid-feedback">
                        {{ $errors->first('content') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.course.fields.content_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="extra_content">{{ trans('cruds.course.fields.extra_content') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('extra_content') ? 'is-invalid' : '' }}" name="extra_content" id="extra_content">{!! old('extra_content') !!}</textarea>
                @if($errors->has('extra_content'))
                    <div class="invalid-feedback">
                        {{ $errors->first('extra_content') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.course.fields.extra_content_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="featured_image">{{ trans('cruds.course.fields.featured_image') }}</label>
                <div class="needsclick dropzone {{ $errors->has('featured_image') ? 'is-invalid' : '' }}" id="featured_image-dropzone">
                </div>
                @if($errors->has('featured_image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('featured_image') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.course.fields.featured_image_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="featured_image_caption">{{ trans('cruds.course.fields.featured_image_caption') }}</label>
                <input class="form-control {{ $errors->has('featured_image_caption') ? 'is-invalid' : '' }}" type="text" name="featured_image_caption" id="featured_image_caption" value="{{ old('featured_image_caption', '') }}">
                @if($errors->has('featured_image_caption'))
                    <div class="invalid-feedback">
                        {{ $errors->first('featured_image_caption') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.course.fields.featured_image_caption_helper') }}</span>
            </div>















            
            <div class="form-group">
                <label for="study_material">{{ trans('cruds.course.fields.study_material') }}</label>
                <div class="needsclick dropzone {{ $errors->has('study_material') ? 'is-invalid' : '' }}" id="study_material-dropzone">
                </div>
                @if($errors->has('study_material'))
                    <div class="invalid-feedback">
                        {{ $errors->first('study_material') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.course.fields.study_material_helper') }}</span>
            </div>



















            <div class="form-group">
                <label for="timetable">{{ trans('cruds.course.fields.timetable') }}</label>
                <div class="needsclick dropzone {{ $errors->has('timetable') ? 'is-invalid' : '' }}" id="timetable-dropzone">
                </div>
                @if($errors->has('timetable'))
                    <div class="invalid-feedback">
                        {{ $errors->first('timetable') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.course.fields.timetable_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="faculties">{{ trans('cruds.course.fields.faculty') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('faculties') ? 'is-invalid' : '' }}" name="faculties[]" id="faculties" multiple>
                    @foreach($faculties as $id => $faculty)
                        <option value="{{ $id }}" {{ in_array($id, old('faculties', [])) ? 'selected' : '' }}>{{ $faculty }}</option>
                    @endforeach
                </select>
                @if($errors->has('faculties'))
                    <div class="invalid-feedback">
                        {{ $errors->first('faculties') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.course.fields.faculty_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="course_categories">{{ trans('cruds.course.fields.course_category') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('course_categories') ? 'is-invalid' : '' }}" name="course_categories[]" id="course_categories" multiple>
                    @foreach($course_categories as $id => $course_category)
                        <option value="{{ $id }}" {{ in_array($id, old('course_categories', [])) ? 'selected' : '' }}>{{ $course_category }}</option>
                    @endforeach
                </select>
                @if($errors->has('course_categories'))
                    <div class="invalid-feedback">
                        {{ $errors->first('course_categories') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.course.fields.course_category_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('featured') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="featured" value="0">
                    <input class="form-check-input" type="checkbox" name="featured" id="featured" value="1" {{ old('featured', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="featured">{{ trans('cruds.course.fields.featured') }}</label>
                </div>
                @if($errors->has('featured'))
                    <div class="invalid-feedback">
                        {{ $errors->first('featured') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.course.fields.featured_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('active') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="active" value="0">
                    <input class="form-check-input" type="checkbox" name="active" id="active" value="1" {{ old('active', 0) == 1 || old('active') === null ? 'checked' : '' }}>
                    <label class="form-check-label" for="active">{{ trans('cruds.course.fields.active') }}</label>
                </div>
                @if($errors->has('active'))
                    <div class="invalid-feedback">
                        {{ $errors->first('active') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.course.fields.active_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="sequence">{{ trans('cruds.course.fields.sequence') }}</label>
                <input class="form-control {{ $errors->has('sequence') ? 'is-invalid' : '' }}" type="number" name="sequence" id="sequence" value="{{ old('sequence', '1') }}" step="1">
                @if($errors->has('sequence'))
                    <div class="invalid-feedback">
                        {{ $errors->first('sequence') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.course.fields.sequence_helper') }}</span>
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
                xhr.open('POST', '{{ route('admin.courses.storeCKEditorImages') }}', true);
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
                data.append('crud_id', '{{ $course->id ?? 0 }}');
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

<script>
    Dropzone.options.featuredImageDropzone = {
    url: '{{ route('admin.courses.storeMedia') }}',
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
@if(isset($course) && $course->featured_image)
      var file = {!! json_encode($course->featured_image) !!}
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








<script>
    Dropzone.options.studyMaterialDropzone = {
        url: '{{ route('admin.courses.storeMedia') }}',
        maxFilesize: 100, // MB
        addRemoveLinks: true,
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        params: {
            size: 100
        },
        success: function (file, response) {
            // 🔹 Change: ab hidden input array me hoga (multiple support ke liye)
            $('form').append('<input type="hidden" name="study_material[]" value="' + response.name + '">')
            file._uploadedName = response.name // 🔹 Change: remove ke time kaam aayega
        },
        removedfile: function (file) {
            file.previewElement.remove()
            if (file.status !== 'error') {
                // 🔹 Change: sirf specific file ka input remove hoga
                $('form').find('input[name="study_material[]"][value="' + file._uploadedName + '"]').remove()
                this.options.maxFiles = this.options.maxFiles + 1
            }
        },
        init: function () {
            @if(isset($course) && $course->study_material)
                // 🔹 Change: multiple files handle karne ke liye loop
                var files = {!! json_encode($course->study_material) !!}
                for (var i in files) {
                    var file = files[i]
                    this.options.addedfile.call(this, file)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="study_material[]" value="' + file.file_name + '">')
                    this.options.maxFiles = this.options.maxFiles - 1
                }
            @endif
        },
        error: function (file, response) {
            if ($.type(response) === 'string') {
                var message = response // dropzone sends it's own error messages in string
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
    Dropzone.options.timetableDropzone = {
    url: '{{ route('admin.courses.storeMedia') }}',
    maxFilesize: 10, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 10,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="timetable"]').remove()
      $('form').append('<input type="hidden" name="timetable" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="timetable"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($course) && $course->timetable)
      var file = {!! json_encode($course->timetable) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="timetable" value="' + file.file_name + '">')
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