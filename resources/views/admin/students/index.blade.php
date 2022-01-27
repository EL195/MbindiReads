@extends('layouts.admin')
@section('content')

    <div class="block my-4">
        <h1>{{ trans('cruds.global.students') }}
        @if($role ?? ''=="School")
        <span>Of {{$classe->name ?? ''}}</span>
        
        @endif
        </h1>
    </div>

    <div class="block my-4">
        @if($count<=$settings->value)
        <a class="btn-md btn-green" href="{{ route('admin.students.create', ['class' => $classe->id ?? '']) }}">
            {{ trans('global.add') }} {{ trans('cruds.global.student') }}
        </a>
        @endif
        @if($role=="Parent")
        @if($count!=0)
        <a class="btn-md" style="background-color:purple; color: white;" href="{{ route('admin.pay.create') }}">
            {{ trans('global.add') }} {{ trans('cruds.global.makep') }}
        </a>
        @endif
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
  height: 350px;
  border-radius: 10px;
}

.available {
  border: 1px solid #ccc;
  box-shadow: 2px 2px 6px 0px rgba(0,0,0,0.3);
  height: 350px;
  border-radius: 10px;
  background: #626262;
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
    @if($role ?? ''=="Parent")
      @foreach($students as $key => $student)
        <article>
          <img src="/img/avatar.png" alt="Sample photo">
          <div class="text">
            <h3>{{$student->first_name}}</h3>
            <br>
                  <div>
            <table>
            <td>
                 <span class="btn-sm btn-indigo" onclick="myFunction('<?php echo $student->username; ?>','<?php echo $student->password; ?>');">
                                              {{ trans('cruds.global.switchs') }}
                                          </span>
                <a class="btn-sm btn-blue" href="{{ route('admin.students.edit', $student->id) }}">
                                              {{ trans('global.edit') }}
                                          </a>
           
                                <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                              <input type="hidden" name="_method" value="DELETE">
                                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                              <input type="submit" class="btn-sm btn-red" value="{{ trans('global.delete') }}">
                                          </form>
            </td>
            </table>
          </div>
          </div>
        </article>
        @endforeach
    @endif

    @if($role=="School")
      @foreach($students as $key => $student)
        <article>
          <img src="/img/avatar.png" alt="Sample photo">
          <div class="text">
            <h3>{{$student->first_name}}</h3>
            <br>
                  <div>
            <table>
            <td>
                    <span class="btn-sm btn-indigo" onclick="myFunction('<?php echo $student->username; ?>','<?php echo $student->password; ?>');">
                                              {{ trans('cruds.global.switchs') }}
                                          </span>
                                          
                <a class="btn-sm btn-blue" href="{{ route('admin.students.edit', $student->id) }}">
                                              {{ trans('global.edit') }}
                                          </a>
        
                                <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                              <input type="hidden" name="_method" value="DELETE">
                                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                              <input type="submit" class="btn-sm btn-red" value="{{ trans('global.delete') }}">
                                          </form>
            </td>
            </table>
          </div>
          </div>
        </article>
      @endforeach

      @for ($x = 1; $x <= $remain; $x++) 
                  <article class="available">
                  
                  </article>
      @endfor
    @endif
</main>
@endsection

@section('scripts')
<script>
function myFunction(username, code) {
  //confirm("Press a button!\nEither OK or Cancel.");
  if (confirm("Continue?\nEither OK or Cancel.") == true) {
    localStorage.removeItem("student");
    localStorage.removeItem("code");
    localStorage.setItem("student", username);
    localStorage.setItem("code", code);
    window.location.href = "https://mbindireads.com";
  } else {
    text = "You canceled!";
  }
}
</script>
@endsection