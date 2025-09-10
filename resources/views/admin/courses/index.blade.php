@extends('layouts.admin')
@section('content')
@can('course_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.courses.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.course.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.course.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Course">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.course.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.course.fields.heading') }}
                    </th>
                    <th>
                        {{ trans('cruds.course.fields.slug') }}
                    </th>
                    <th>
                        {{ trans('cruds.course.fields.sub_heading') }}
                    </th>
                    <th>
                        {{ trans('cruds.course.fields.language') }}
                    </th>
                    <th>
                        {{ trans('cruds.course.fields.duration') }}
                    </th>
                    <th>
                        {{ trans('cruds.course.fields.video_lectures') }}
                    </th>
                    <th>
                        {{ trans('cruds.course.fields.questions_count') }}
                    </th>
                    <th>
                        {{ trans('cruds.course.fields.enrolment_deadline_date') }}
                    </th>
                    <th>
                        {{ trans('cruds.course.fields.price') }}
                    </th>
                    <th>
                        {{ trans('cruds.course.fields.short_description') }}
                    </th>
                    <th>
                        {{ trans('cruds.course.fields.long_description') }}
                    </th>
                    <th>
                        {{ trans('cruds.course.fields.featured_image') }}
                    </th>
                    <th>
                        {{ trans('cruds.course.fields.featured_image_caption') }}
                    </th>
                    <th>
                        {{ trans('cruds.course.fields.study_material') }}
                    </th>
                    <th>
                        {{ trans('cruds.course.fields.timetable') }}
                    </th>
                    <th>
                        {{ trans('cruds.course.fields.faculty') }}
                    </th>
                    <th>
                        {{ trans('cruds.course.fields.course_category') }}
                    </th>
                    <th>
                        {{ trans('cruds.course.fields.featured') }}
                    </th>
                    <th>
                        {{ trans('cruds.course.fields.active') }}
                    </th>
                    <th>
                        {{ trans('cruds.course.fields.sequence') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
                <tr>
                    <td>
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <select class="search" strict="true">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach(App\Models\Course::LANGUAGE_SELECT as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                        <select class="search">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach($faculties as $key => $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select class="search">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach($course_categories as $key => $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                    </td>
                </tr>
            </thead>
        </table>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('course_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.courses.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
          return entry.id
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

  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.courses.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'heading', name: 'heading' },
{ data: 'slug', name: 'slug' },
{ data: 'sub_heading', name: 'sub_heading' },
{ data: 'language', name: 'language' },
{ data: 'duration', name: 'duration' },
{ data: 'video_lectures', name: 'video_lectures' },
{ data: 'questions_count', name: 'questions_count' },
{ data: 'enrolment_deadline_date', name: 'enrolment_deadline_date' },
{ data: 'price', name: 'price' },
{ data: 'short_description', name: 'short_description' },
{ data: 'long_description', name: 'long_description' },
{ data: 'featured_image', name: 'featured_image', sortable: false, searchable: false },
{ data: 'featured_image_caption', name: 'featured_image_caption' },
{ data: 'study_material', name: 'study_material', sortable: false, searchable: false },



{ data: 'timetable', name: 'timetable', sortable: false, searchable: false },
{ data: 'faculty', name: 'faculties.name' },
{ data: 'course_category', name: 'course_categories.name' },
{ data: 'featured', name: 'featured' },
{ data: 'active', name: 'active' },
{ data: 'sequence', name: 'sequence' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-Course').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
let visibleColumnsIndexes = null;
$('.datatable thead').on('input', '.search', function () {
      let strict = $(this).attr('strict') || false
      let value = strict && this.value ? "^" + this.value + "$" : this.value

      let index = $(this).parent().index()
      if (visibleColumnsIndexes !== null) {
        index = visibleColumnsIndexes[index]
      }

      table
        .column(index)
        .search(value, strict)
        .draw()
  });
table.on('column-visibility.dt', function(e, settings, column, state) {
      visibleColumnsIndexes = []
      table.columns(":visible").every(function(colIdx) {
          visibleColumnsIndexes.push(colIdx);
      });
  })
});

</script>
@endsection