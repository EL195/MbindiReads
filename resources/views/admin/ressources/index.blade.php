@extends('layouts.admin')
@section('content')
@can('folder_create')
    <div class="block my-4">
        <h1>
        {{ trans('cruds.menu.ressources') }}
        </h1>
    </div>

    <div class="block my-4" style="float: right;">
        <a class="btn-md btn-green items-end" href="{{ route('admin.ressources.create') }}">
            {{ trans('global.add') }} {{ trans('cruds.global.ressource') }}
        </a>
    </div>
@endcan
<div class="main-card">
{{--     <div class="header">
        {{ trans('cruds.folder.title_singular') }} {{ trans('global.list') }}
    </div> --}}

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
                            {{ trans('cruds.folder.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.global.level') }}
                        </th>
                         <th>
                            {{ trans('cruds.global.age') }}
                        </th>
                        <th>
                            {{ trans('cruds.global.subject') }}
                        </th>
                        <th>
                            {{ trans('cruds.global.genre') }}
                        </th>
                        <th>
                            {{ trans('cruds.global.theme') }}
                        </th>
                        <th>
                            {{ trans('cruds.global.langue') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ressources as $key => $ressource)
                        <tr data-entry-id="{{ $ressource->id }}">
                            <td>

                            </td>
                            <td style="text-align: center;">
                                {{ $ressource->id ?? '' }}
                            </td>
                            <td style="text-align: center;">
                                {{ $ressource->name ?? '' }}
                            </td>
                            <td style="text-align: center;">
                                {{ $ressource->level->name ?? '' }}
                            </td>
                            <td style="text-align: center;">
                                {{ $ressource->agegroup->name ?? '' }}
                            </td>
                            <td style="text-align: center;">
                                {{ $ressource->subject->name ?? '' }}
                            </td>
                            <td style="text-align: center;">
                                {{ $ressource->genre->name ?? '' }}
                            </td>
                              <td style="text-align: center;">
                                {{ $ressource->theme->name ?? '' }}
                            </td>
                            <td style="text-align: center;">
                             {{ $ressource->langue->title }}
                            </td>
                            <td style="float: right;">
                                    <a href="{{ $ressource->file_path }}" target="_blank">
                                        {{ trans('cruds.global.viewPdf') }}
                                    </a>
                                @foreach($ressource->files as $key => $media)
                                    <a href="{{ $media->getUrl() }}" target="_blank">
                                        {{ trans('cruds.global.viewPdf') }}
                                    </a>
                                @endforeach

                                @can('folder_show')
                                    <a class="btn-sm btn-indigo" href="{{ route('admin.ressources.show', $ressource->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan 

                                @can('folder_edit')
                                    <a class="btn-sm btn-blue" href="{{ route('admin.ressources.edit', $ressource->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('folder_delete')
                                    <form action="{{ route('admin.ressources.destroy', $ressource->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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