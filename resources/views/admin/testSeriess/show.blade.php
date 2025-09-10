@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.testSeries.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.test-seriess.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.testSeries.fields.id') }}
                        </th>
                        <td>
                            {{ $test_seriess->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.testSeries.fields.heading') }}
                        </th>
                        <td>
                            {{ $test_seriess->heading }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.testSeries.fields.slug') }}
                        </th>
                        <td>
                            {{ $test_seriess->slug }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.testSeries.fields.sub_heading') }}
                        </th>
                        <td>
                            {{ $test_seriess->sub_heading }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.testSeries.fields.language') }}
                        </th>
                        <td>
                            {{ App\Models\TestSeries::LANGUAGE_SELECT[$test_seriess->language] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.testSeries.fields.duration') }}
                        </th>
                        <td>
                            {{ $test_seriess->duration }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.testSeries.fields.video_lectures') }}
                        </th>
                        <td>
                            {{ $test_seriess->video_lectures }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.testSeries.fields.questions_count') }}
                        </th>
                        <td>
                            {{ $test_seriess->questions_count }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.testSeries.fields.enrolment_deadline_date') }}
                        </th>
                        <td>
                            {{ $test_seriess->enrolment_deadline_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.testSeries.fields.price') }}
                        </th>
                        <td>
                            {{ $test_seriess->price }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.testSeries.fields.short_description') }}
                        </th>
                        <td>
                            {{ $test_seriess->short_description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.testSeries.fields.long_description') }}
                        </th>
                        <td>
                            {{ $test_seriess->long_description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.testSeries.fields.content') }}
                        </th>
                        <td>
                            {!! $test_seriess->content !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.testSeries.fields.extra_content') }}
                        </th>
                        <td>
                            {!! $test_seriess->extra_content !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.testSeries.fields.featured_image') }}
                        </th>
                        <td>
                            @if($test_seriess->featured_image)
                                <a href="{{ $test_seriess->featured_image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $test_seriess->featured_image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.testSeries.fields.featured_image_caption') }}
                        </th>
                        <td>
                            {{ $test_seriess->featured_image_caption }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.testSeries.fields.study_material') }}
                        </th>
                        <td>
                            @if($test_seriess->study_material)
                                <a href="{{ $test_seriess->study_material->getUrl() }}" target="_blank">
                                    {{ trans('global.downloadFile') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.testSeries.fields.timetable') }}
                        </th>
                        <td>
                            @if($test_seriess->timetable)
                                <a href="{{ $test_seriess->timetable->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $test_seriess->timetable->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.testSeries.fields.faculty') }}
                        </th>
                        <td>
                            @foreach($test_seriess->faculties as $key => $faculty)
                                <span class="label label-info">{{ $faculty->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.testSeries.fields.test_series_category') }}
                        </th>
                        <td>
                            @foreach($test_seriess->test_series_categories as $key => $test_series_category)
                                <span class="label label-info">{{ $test_series_category->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.testSeries.fields.featured') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $test_seriess->featured ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.testSeries.fields.active') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $test_seriess->active ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.testSeries.fields.sequence') }}
                        </th>
                        <td>
                            {{ $test_seriess->sequence }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.test-seriess.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
