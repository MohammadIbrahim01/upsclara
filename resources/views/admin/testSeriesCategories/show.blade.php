@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.testSeriesCategory.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.test-series-categories.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.testSeriesCategory.fields.id') }}
                        </th>
                        <td>
                            {{ $testSeriesCategory->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.testSeriesCategory.fields.name') }}
                        </th>
                        <td>
                            {{ $testSeriesCategory->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.testSeriesCategory.fields.slug') }}
                        </th>
                        <td>
                            {{ $testSeriesCategory->slug }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.testSeriesCategory.fields.test_series_category') }}
                        </th>
                        <td>
                            {{ $testSeriesCategory->test_series_category->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.testSeriesCategory.fields.sequence') }}
                        </th>
                        <td>
                            {{ $testSeriesCategory->sequence }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.testSeriesCategory.fields.active') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $testSeriesCategory->active ? 'checked' : '' }}>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.test-series-categories.index') }}">
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
            <a class="nav-link" href="#test_series_category_test_seriess" role="tab" data-toggle="tab">
                {{ trans('cruds.testSeries.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="test_series_category_test_seriess">
            @includeIf('admin.testSeriesCategories.relationships.testSeriesCategoryTestSeriess', ['testSeriess' => $testSeriesCategory->testSeriesCategoryTestSeriess])
        </div>
    </div>
</div>

@endsection