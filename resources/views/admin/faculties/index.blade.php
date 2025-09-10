@extends('layouts.admin')
@section('content')
@can('faculty_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.faculties.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.faculty.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.faculty.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Faculty">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.faculty.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.faculty.fields.name') }}
                    </th>
                    <th>
                        {{ trans('cruds.faculty.fields.slug') }}
                    </th>
                    <th>
                        {{ trans('cruds.faculty.fields.designation') }}
                    </th>
                    <th>
                        {{ trans('cruds.faculty.fields.experience') }}
                    </th>
                    <th>
                        {{ trans('cruds.faculty.fields.qualifications') }}
                    </th>
                    <th>
                        {{ trans('cruds.faculty.fields.specialization') }}
                    </th>
                    <th>
                        {{ trans('cruds.faculty.fields.short_description') }}
                    </th>
                    <th>
                        {{ trans('cruds.faculty.fields.long_description') }}
                    </th>
                    <th>
                        {{ trans('cruds.faculty.fields.featured_image') }}
                    </th>
                    <th>
                        {{ trans('cruds.faculty.fields.facebook_link') }}
                    </th>
                    <th>
                        {{ trans('cruds.faculty.fields.instagram_link') }}
                    </th>
                    <th>
                        {{ trans('cruds.faculty.fields.twitter_link') }}
                    </th>
                    <th>
                        {{ trans('cruds.faculty.fields.linkedin_link') }}
                    </th>
                    <th>
                        {{ trans('cruds.faculty.fields.youtube_link') }}
                    </th>
                    <th>
                        {{ trans('cruds.faculty.fields.course') }}
                    </th>
                    <th>
                        {{ trans('cruds.faculty.fields.test_series') }}
                    </th>
                    <th>
                        {{ trans('cruds.faculty.fields.sequence') }}
                    </th>
                    <th>
                        {{ trans('cruds.faculty.fields.active') }}
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
                        <select class="search">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach($courses as $key => $item)
                                <option value="{{ $item->heading }}">{{ $item->heading }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select class="search">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach($test_seriess as $key => $item)
                                <option value="{{ $item->heading }}">{{ $item->heading }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
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
@can('faculty_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.faculties.massDestroy') }}",
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
    ajax: "{{ route('admin.faculties.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'name', name: 'name' },
{ data: 'slug', name: 'slug' },
{ data: 'designation', name: 'designation' },
{ data: 'experience', name: 'experience' },
{ data: 'qualifications', name: 'qualifications' },
{ data: 'specialization', name: 'specialization' },
{ data: 'short_description', name: 'short_description' },
{ data: 'long_description', name: 'long_description' },
{ data: 'featured_image', name: 'featured_image', sortable: false, searchable: false },
{ data: 'facebook_link', name: 'facebook_link' },
{ data: 'instagram_link', name: 'instagram_link' },
{ data: 'twitter_link', name: 'twitter_link' },
{ data: 'linkedin_link', name: 'linkedin_link' },
{ data: 'youtube_link', name: 'youtube_link' },
{ data: 'course', name: 'courses.heading' },
{ data: 'test_series', name: 'test_series.heading' },
{ data: 'sequence', name: 'sequence' },
{ data: 'active', name: 'active' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-Faculty').DataTable(dtOverrideGlobals);
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