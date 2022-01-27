@extends('layouts.admin')
@section('content')
@can('folder_create')
    <div class="block my-4">
        <h1>
        {{ trans('cruds.global.notifications') }}
        </h1>
    </div>


@endcan
<div class="main-card">

    <div class="body">
        <div class="w-full">
            <table class="stripe hover bordered datatable ">
                <thead>
                    <tr>
                        <th width="10">
                        </th>
                        <th>
                            {{ trans('cruds.folder.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.global.content') }}
                        </th>
                        <th>
                            {{ trans('cruds.global.status') }}
                        </th>
                         <th>
                            {{ trans('cruds.global.content') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($notifications as $key => $notification)
                        <tr data-entry-id="{{ $notification->id }}">
                            <td>

                            </td>
                            <td style="text-align: center;">
                                {{ $notification->id ?? '' }}
                            </td>
                            <td style="text-align: center;">
                                {{ $notification->price ?? '' }}
                            </td>
                            <td style="text-align: center;">
                                {{ $notification->users->name ?? '' }}
                            </td>
                            <td style="text-align: center;">
                                {{ $notification->membership->name ?? '' }}
                            </td>
                              <td style="text-align: center;">
                                {{ $notification->status ?? '' }}
                            </td>

                      
                            <td style="float: right;">

                                @can('folder_edit')
                                    <a class="btn-sm btn-blue" href="{{ route('admin.payement.edit', $notification->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('folder_delete')
                                    <form action="{{ route('admin.payement.destroy', $notification->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn-sm btn-red" value="{{ trans('global.delete') }}">
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



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('folder_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.levels.massDestroy') }}",
    className: 'btn-red',
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
  let table = $('.datatable-Folder:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection