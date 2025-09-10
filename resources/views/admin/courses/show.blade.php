@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.course.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.courses.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>
                                {{ trans('cruds.course.fields.id') }}
                            </th>
                            <td>
                                {{ $course->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.course.fields.heading') }}
                            </th>
                            <td>
                                {{ $course->heading }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.course.fields.slug') }}
                            </th>
                            <td>
                                {{ $course->slug }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.course.fields.sub_heading') }}
                            </th>
                            <td>
                                {{ $course->sub_heading }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.course.fields.language') }}
                            </th>
                            <td>
                                {{ App\Models\Course::LANGUAGE_SELECT[$course->language] ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.course.fields.duration') }}
                            </th>
                            <td>
                                {{ $course->duration }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.course.fields.video_lectures') }}
                            </th>
                            <td>
                                {{ $course->video_lectures }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.course.fields.questions_count') }}
                            </th>
                            <td>
                                {{ $course->questions_count }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.course.fields.enrolment_deadline_date') }}
                            </th>
                            <td>
                                {{ $course->enrolment_deadline_date }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.course.fields.price') }}
                            </th>
                            <td>
                                {{ $course->price }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.course.fields.short_description') }}
                            </th>
                            <td>
                                {{ $course->short_description }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.course.fields.long_description') }}
                            </th>
                            <td>
                                {{ $course->long_description }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.course.fields.content') }}
                            </th>
                            <td>
                                {!! $course->content !!}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.course.fields.extra_content') }}
                            </th>
                            <td>
                                {!! $course->extra_content !!}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.course.fields.featured_image') }}
                            </th>
                            <td>


                                @if ($course->featured_image)
                                    <a href="{{ $course->featured_image->getUrl() }}" target="_blank"
                                        style="display: inline-block">
                                        <img src="{{ $course->featured_image->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.course.fields.featured_image_caption') }}
                            </th>
                            <td>
                                {{ $course->featured_image_caption }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.course.fields.study_material') }}
                            </th>
                            <td>
                                @if ($course->study_material && $course->study_material->count() > 0)
                                    @php
                                        // sabhi files ka naam clean karke ek naya collection banayenge
                                        $sortedFiles = $course->study_material
                                            ->map(function ($media) {
                                                $fileName = $media->file_name;
                                                // prefix remove karna (jaise 68b71a967f8fd_)
                                                $cleanName = preg_replace('/^[a-zA-Z0-9]+_/', '', $fileName);
                                                return [
                                                    'media' => $media,
                                                    'cleanName' => $cleanName,
                                                ];
                                            })
                                            ->sortBy(function ($item) {
                                                // agar naam alphabet se start hota hai to priority 1
                                                // agar number se start hota hai to priority 2
                                                return (preg_match('/^[a-zA-Z]/', $item['cleanName']) ? '1_' : '2_') .
                                                    strtolower($item['cleanName']);
                                            });
                                    @endphp

                                    @foreach ($sortedFiles as $file)
                                        <a href="{{ $file['media']->getUrl() }}" target="_blank">
                                            {{ $file['cleanName'] }}
                                        </a><br>
                                    @endforeach
                                @else
                                    {{ trans('global.no_file') }}
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th>
                                {{ trans('cruds.course.fields.timetable') }}
                            </th>
                            <td>
                                @if ($course->timetable)
                                    <a href="{{ $course->timetable->getUrl() }}" target="_blank"
                                        style="display: inline-block">
                                        <img src="{{ $course->timetable->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.course.fields.faculty') }}
                            </th>
                            <td>
                                @foreach ($course->faculties as $key => $faculty)
                                    <span class="label label-info">{{ $faculty->name }}</span>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.course.fields.course_category') }}
                            </th>
                            <td>
                                @foreach ($course->course_categories as $key => $course_category)
                                    <span class="label label-info">{{ $course_category->name }}</span>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.course.fields.featured') }}
                            </th>
                            <td>
                                <input type="checkbox" disabled="disabled" {{ $course->featured ? 'checked' : '' }}>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.course.fields.active') }}
                            </th>
                            <td>
                                <input type="checkbox" disabled="disabled" {{ $course->active ? 'checked' : '' }}>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.course.fields.sequence') }}
                            </th>
                            <td>
                                {{ $course->sequence }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.courses.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            {{ trans('global.relatedData') }}
        </div>
        <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
            <li class="nav-item">
                <a class="nav-link" href="#course_course_contents" role="tab" data-toggle="tab">
                    {{ trans('cruds.courseContent.title') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#course_course_faqs" role="tab" data-toggle="tab">
                    {{ trans('cruds.courseFaq.title') }}
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane" role="tabpanel" id="course_course_contents">
                @includeIf('admin.courses.relationships.courseCourseContents', [
                    'courseContents' => $course->courseCourseContents,
                ])
            </div>
            <div class="tab-pane" role="tabpanel" id="course_course_faqs">
                @includeIf('admin.courses.relationships.courseCourseFaqs', [
                    'courseFaqs' => $course->courseCourseFaqs,
                ])
            </div>
        </div>
    </div>

@endsection
