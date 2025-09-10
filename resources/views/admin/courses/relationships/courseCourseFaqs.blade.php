@can('course_faq_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.course-faqs.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.courseFaq.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.courseFaq.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-courseCourseFaqs">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.courseFaq.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.courseFaq.fields.course') }}
                        </th>
                        <th>
                            {{ trans('cruds.courseFaq.fields.question') }}
                        </th>
                        <th>
                            {{ trans('cruds.courseFaq.fields.answer') }}
                        </th>
                        <th>
                            {{ trans('cruds.courseFaq.fields.sequence') }}
                        </th>
                        <th>
                            {{ trans('cruds.courseFaq.fields.active') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($courseFaqs as $key => $courseFaq)
                        <tr data-entry-id="{{ $courseFaq->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $courseFaq->id ?? '' }}
                            </td>
                            <td>
                                {{ $courseFaq->course->heading ?? '' }}
                            </td>
                            <td>
                                {{ $courseFaq->question ?? '' }}
                            </td>
                            <td>
                                {{ $courseFaq->answer ?? '' }}
                            </td>
                            <td>
                                {{ $courseFaq->sequence ?? '' }}
                            </td>
                            <td>
                                <span style="display:none">{{ $courseFaq->active ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $courseFaq->active ? 'checked' : '' }}>
                            </td>
                            <td>
                                @can('course_faq_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.course-faqs.show', $courseFaq->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('course_faq_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.course-faqs.edit', $courseFaq->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('course_faq_delete')
                                    <form action="{{ route('admin.course-faqs.destroy', $courseFaq->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('course_faq_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.course-faqs.massDestroy') }}",
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
  let table = $('.datatable-courseCourseFaqs:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection