@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('cruds.socialMedium.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-SocialMedium">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.socialMedium.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.socialMedium.fields.company') }}
                        </th>
                        <th>
                            {{ trans('cruds.socialMedium.fields.facebook_link') }}
                        </th>
                        <th>
                            {{ trans('cruds.socialMedium.fields.instagram_link') }}
                        </th>
                        <th>
                            {{ trans('cruds.socialMedium.fields.twitter_link') }}
                        </th>
                        <th>
                            {{ trans('cruds.socialMedium.fields.linkedin_link') }}
                        </th>
                        <th>
                            {{ trans('cruds.socialMedium.fields.youtube_link') }}
                        </th>
                        <th>
                            {{ trans('cruds.socialMedium.fields.google_link') }}
                        </th>
                        <th>
                            {{ trans('cruds.socialMedium.fields.snapchat_link') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($socialMedia as $key => $socialMedium)
                        <tr data-entry-id="{{ $socialMedium->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $socialMedium->id ?? '' }}
                            </td>
                            <td>
                                {{ $socialMedium->company->name ?? '' }}
                            </td>
                            <td>
                                {{ $socialMedium->facebook_link ?? '' }}
                            </td>
                            <td>
                                {{ $socialMedium->instagram_link ?? '' }}
                            </td>
                            <td>
                                {{ $socialMedium->twitter_link ?? '' }}
                            </td>
                            <td>
                                {{ $socialMedium->linkedin_link ?? '' }}
                            </td>
                            <td>
                                {{ $socialMedium->youtube_link ?? '' }}
                            </td>
                            <td>
                                {{ $socialMedium->google_link ?? '' }}
                            </td>
                            <td>
                                {{ $socialMedium->snapchat_link ?? '' }}
                            </td>
                            <td>
                                @can('social_medium_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.social-media.show', $socialMedium->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('social_medium_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.social-media.edit', $socialMedium->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan


                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
  
  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-SocialMedium:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection