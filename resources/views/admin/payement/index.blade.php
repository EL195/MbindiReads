@extends('layouts.admin')
@section('content')
@can('folder_create')
    <div class="block my-4">
        <h1>
        {{ trans('cruds.global.payements') }}
        </h1>
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
                            {{ trans('cruds.global.price') }}
                        </th>
                        @if($role=="Admin")
                        <th>
                            {{ trans('cruds.global.users') }}
                
                        </th>
                        @endif
             
                        <th>
                            {{ trans('cruds.global.membership') }}
                        </th>
                       @if($role!="Admin")
                        <th>
                            {{ trans('cruds.global.beneficiary') }}
                        </th>
                        @endif
                      


                        <th>
                            {{ trans('cruds.global.status') }}
                        </th>
                                   <th>
                            {{ trans('cruds.global.validity') }}
                
                        </th>
{{--                        <th>
                            {{ trans('cruds.folder.fields.folder') }}
                        </th>
                        <th>
                            {{ trans('cruds.folder.fields.files') }}
                        </th> --}}
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payements as $key => $payement)
                        <tr data-entry-id="{{ $payement->id }}">
                            <td>

                            </td>
                            <td style="text-align: center;">
                                {{ $payement->id ?? '' }}
                            </td>
                            <td style="text-align: center;">
                                {{ $payement->price ?? '' }} XAF
                            </td>
                            @if($role=="Admin")
                            <td style="text-align: center;">
                                {{ $payement->user->name ?? '' }}
                            </td>
                            @endif
                            <td style="text-align: center;">
                                {{ $payement->membership->name ?? '' }}
                            </td>

                            @if($role=="Parent")
                            <td style="text-align: center;">
                                {{ $payement->student->first_name ?? '' }}
                            </td>
                            @endif
                            @if($role=="School")
                            <td style="text-align: center;">
                               {{ $payement->classe->name ?? '' }}
                            </td>
                            @endif
                            @if($payement->status==1)
                            <td style="text-align: center;">
                               {{ trans('cruds.global.paid') }}
                            </td>
                            @else
                            <td style="text-align: center;">
                                 {{ trans('cruds.global.waitingv') }}
                            </td>
                            @endif
                            @if($payement->status==1 && $payement->start==1)
                            <td style="text-align: center;">
                               {{ date('Y-m-d', strtotime($payement->updated_at. ' + '.$payement->membership->periode.'days')) }}
                            </td>
                            @endif
                      
                            <td style="float: right;">
{{--                                 @can('folder_show')
                                    <a class="btn-sm btn-indigo" href="{{ route('admin.subjects.show', $subject->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan --}}
                                @if($role=="Admin")
                    
                                @endif

                                @can('folder_delete')
                                @if($payement->start==0)
                                    <form action="{{ route('admin.payement.destroy', $payement->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn-sm btn-green" value="{{ trans('cruds.global.validate') }}">
                                    </form>
                                @endif
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