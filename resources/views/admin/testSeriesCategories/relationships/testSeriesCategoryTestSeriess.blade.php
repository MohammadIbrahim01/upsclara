@can('test_series_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.test-seriess.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.testSeries.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.testSeries.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-testSeriesCategoryTestSeriess">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.testSeries.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.testSeries.fields.heading') }}
                        </th>
                        <th>
                            {{ trans('cruds.testSeries.fields.slug') }}
                        </th>
                        <th>
                            {{ trans('cruds.testSeries.fields.sub_heading') }}
                        </th>
                        <th>
                            {{ trans('cruds.testSeries.fields.language') }}
                        </th>
                        <th>
                            {{ trans('cruds.testSeries.fields.duration') }}
                        </th>
                        <th>
                            {{ trans('cruds.testSeries.fields.video_lectures') }}
                        </th>
                        <th>
                            {{ trans('cruds.testSeries.fields.questions_count') }}
                        </th>
                        <th>
                            {{ trans('cruds.testSeries.fields.enrolment_deadline_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.testSeries.fields.price') }}
                        </th>
                        <th>
                            {{ trans('cruds.testSeries.fields.short_description') }}
                        </th>
                        <th>
                            {{ trans('cruds.testSeries.fields.long_description') }}
                        </th>
                        <th>
                            {{ trans('cruds.testSeries.fields.featured_image') }}
                        </th>
                        <th>
                            {{ trans('cruds.testSeries.fields.featured_image_caption') }}
                        </th>
                        <th>
                            {{ trans('cruds.testSeries.fields.study_material') }}
                        </th>
                        <th>
                            {{ trans('cruds.testSeries.fields.timetable') }}
                        </th>
                        <th>
                            {{ trans('cruds.testSeries.fields.faculty') }}
                        </th>
                        <th>
                            {{ trans('cruds.testSeries.fields.test_series_category') }}
                        </th>
                        <th>
                            {{ trans('cruds.testSeries.fields.featured') }}
                        </th>
                        <th>
                            {{ trans('cruds.testSeries.fields.active') }}
                        </th>
                        <th>
                            {{ trans('cruds.testSeries.fields.sequence') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($testSeriess as $key => $testSeries)
                        <tr data-entry-id="{{ $testSeries->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $testSeries->id ?? '' }}
                            </td>
                            <td>
                                {{ $testSeries->heading ?? '' }}
                            </td>
                            <td>
                                {{ $testSeries->slug ?? '' }}
                            </td>
                            <td>
                                {{ $testSeries->sub_heading ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\TestSeries::LANGUAGE_SELECT[$testSeries->language] ?? '' }}
                            </td>
                            <td>
                                {{ $testSeries->duration ?? '' }}
                            </td>
                            <td>
                                {{ $testSeries->video_lectures ?? '' }}
                            </td>
                            <td>
                                {{ $testSeries->questions_count ?? '' }}
                            </td>
                            <td>
                                {{ $testSeries->enrolment_deadline_date ?? '' }}
                            </td>
                            <td>
                                {{ $testSeries->price ?? '' }}
                            </td>
                            <td>
                                {{ $testSeries->short_description ?? '' }}
                            </td>
                            <td>
                                {{ $testSeries->long_description ?? '' }}
                            </td>
                            <td>
                                @if($testSeries->featured_image)
                                    <a href="{{ $testSeries->featured_image->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $testSeries->featured_image->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                            <td>
                                {{ $testSeries->featured_image_caption ?? '' }}
                            </td>
                            <td>
                                @if($testSeries->study_material)
                                    <a href="{{ $testSeries->study_material->getUrl() }}" target="_blank">
                                        {{ trans('global.view_file') }}
                                    </a>
                                @endif
                            </td>
                            <td>
                                @if($testSeries->timetable)
                                    <a href="{{ $testSeries->timetable->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $testSeries->timetable->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                            <td>
                                @foreach($testSeries->faculties as $key => $item)
                                    <span class="badge badge-info">{{ $item->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                @foreach($testSeries->test_series_categories as $key => $item)
                                    <span class="badge badge-info">{{ $item->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                <span style="display:none">{{ $testSeries->featured ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $testSeries->featured ? 'checked' : '' }}>
                            </td>
                            <td>
                                <span style="display:none">{{ $testSeries->active ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $testSeries->active ? 'checked' : '' }}>
                            </td>
                            <td>
                                {{ $testSeries->sequence ?? '' }}
                            </td>
                            <td>
                                @can('test_series_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.test-seriess.show', $testSeries->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('test_series_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.test-seriess.edit', $testSeries->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('test_series_delete')
                                    <form action="{{ route('admin.test-seriess.destroy', $testSeries->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('test_series_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.test-seriess.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-testSeriesCategoryTestSeriess:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection