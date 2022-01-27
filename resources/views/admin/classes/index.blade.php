@extends('layouts.admin')
@section('content')

    <div class="block my-4">
        <h1>{{ trans('cruds.global.classes') }}</h1>
    </div>

    <div class="block my-4">
        <a class="btn-md btn-green" href="{{ route('admin.classes.create') }}">
            {{ trans('global.add') }} {{ trans('cruds.global.class') }}
        </a>
        @if($count!=0)
        <a class="btn-md" style="background-color:purple; color: white;" href="{{ route('admin.pay.create') }}">
            {{ trans('global.add') }} {{ trans('cruds.global.makep') }}
        </a>
        @endif
    </div>







<style>
.grid { 
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
  grid-gap: 20px;
  align-items: end;
  }
.grid > article {
  border: 1px solid #ccc;
  box-shadow: 2px 2px 6px 0px  rgba(0,0,0,0.3);
}
.grid > article img {
  max-width: 100%;
  border: 3px solid transparent;
}
.text {
  padding: 0 20px 20px;
  text-align: center;
}
.text > button {
  background: gray;
  border: 0;
  color: white;
  padding: 10px;
  width: 100%;
  }
</style>
<main class="grid">
@foreach($classes as $key => $classe)
  <article>
    <img src="/img/class.png" alt="Sample photo">
    <div class="text">
      <h3>{{$classe->name}}</h3>
      <br>
      <div>
      <table>
      <td>
          <a class="btn-sm btn-blue" href="{{ route('admin.classes.edit', $classe->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
           <a class="btn-sm btn-indigo" href="{{ route('admin.students.index', ['class' => $classe->id]) }}">
                                        {{ trans('global.view') }}
                                    </a>
                           <form action="{{ route('admin.classes.destroy', $classe->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn-sm btn-red" value="{{ trans('global.delete') }}">
                                    </form>
      </td>
      </table>
    </div>
  </article>
@endforeach
</main>
@endsection