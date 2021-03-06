@extends('layouts.admin')
@section('content')
@can('user_create')
    <div class="block my-4">
        <h1>
        {{ trans('cruds.menu.users') }}
        </h1>
    </div>
    <div class="block my-4" style="float: right;">
        <a class="btn-md btn-green" href="{{ route('admin.users.create') }}">
            {{ trans('global.add') }} {{ trans('cruds.user.title_singular') }}
        </a>
    </div>
@endcan
<div class="main-card">
    <div class="header">
        {{ trans('cruds.user.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="body">
        <div class="w-full">
            <table class="stripe hover bordered datatable ">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.user.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.user.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.user.fields.email') }}
                        </th>
                        <th>
                            {{ trans('cruds.user.fields.email_verified_at') }}
                        </th>
                        <th>
                            {{ trans('cruds.user.fields.roles') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $key => $user)
                        <tr data-entry-id="{{ $user->id }}">
                            <td>

                            </td>
                            <td style="text-align: center;">
                                {{ $user->id ?? '' }}
                            </td>
                            <td style="text-align: center;">
                                {{ $user->name ?? '' }}
                            </td>
                            <td style="text-align: center;">
                                {{ $user->email ?? '' }}
                            </td>
                            <td style="text-align: center;">
                                {{ $user->email_verified_at ?? '' }}
                            </td>
                            <td style="text-align: center;">
                                @foreach($user->roles as $key => $item)
                                    <span class="badge blue">{{ $item->title }}</span>
                                @endforeach
                            </td>
                            <td>
  {{--                               <a onclick="return confirm('{{ trans('global.areYouSure') }}');"  style="border:1px solid green; border-radius:5px;" class="btn-sm btn-success " href="">
                                        {{ trans('cruds.global.switch') }}
                                </a> --}}

                               {{--    <a style="color: green;border:1px solid green!important; border-radius:5px;" class="btn-sm btn-success" onclick="myFunction('<?php echo $user->email; ?>','<?php echo $user->password; ?>');">
                                              {{ trans('cruds.global.switch') }}
                                          </a> --}}

                                @can('user_show')
                                    <a class="btn-sm btn-indigo" href="{{ route('admin.users.show', $user->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('user_edit')
                                    <a class="btn-sm btn-blue" href="{{ route('admin.users.edit', $user->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan
                            @if($user->id!=1 )
                            @if( $user->id!=4)
                                @can('user_delete')
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn-sm btn-red" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan
                            @endif
                             @endif
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
@can('user_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.users.massDestroy') }}",
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
  let table = $('.datatable-User:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})



</script>
@endsection

@section('scripts')
<script>
function myFunction(username, code) {
  //confirm("Press a button!\nEither OK or Cancel.");
  if (confirm("Continue?\nEither OK or Cancel.") == true) {
    localStorage.removeItem("partner");
    localStorage.removeItem("code_p");
    localStorage.setItem("partner", username);
    localStorage.setItem("code_p", code);
    window.location.href = "https://partners.mbindireads.com";
  } else {
    text = "You canceled!";
  }
}
</script>
@endsection