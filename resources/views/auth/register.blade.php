@extends('layouts.app')

@section('content')
<div class="auth-card">
    <div class="title">
        <img style="border-style: none;" src="{{ asset('img/logo.png')}}" />
    </div>

    <div class="title">
        <h1>New ? Please create your account.</h1>
    </div>

    @if(session('message'))
        <div class="alert success">
            {{ session('message') }}
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <label class="block">
            <span class="text-gray-700 text-sm">{{ trans('cruds.global.last_name') }}</span>
            <input type="text" name="fisrt_name" class="form-input {{ $errors->has('fisrt_name') ? ' is-invalid' : '' }}" value="{{ old('fisrt_name') }}" autofocus required>
            @if($errors->has('fisrt_name'))
                <p class="invalid-feedback">{{ $errors->first('email') }}</p>
            @endif
        </label>


        <label class="block">
            <span class="text-gray-700 text-sm">{{ trans('cruds.global.last_name') }}</span>
            <input type="text" name="last_name" class="form-input {{ $errors->has('last_name') ? ' is-invalid' : '' }}" value="{{ old('last_name') }}" autofocus required>
            @if($errors->has('last_name'))
                <p class="invalid-feedback">{{ $errors->first('last_name') }}</p>
            @endif
        </label>


        <label class="block">
            <span class="text-gray-700 text-sm">{{ trans('cruds.global.phone') }}</span>
            <input type="number" name="phone" class="form-input {{ $errors->has('phone') ? ' is-invalid' : '' }}" value="{{ old('phone') }}" autofocus required>
            @if($errors->has('phone'))
                <p class="invalid-feedback">{{ $errors->first('phone') }}</p>
            @endif
        </label>


        <label class="block">
            <span class="text-gray-700 text-sm">{{ trans('global.login_email') }}</span>
            <input type="email" name="email" class="form-input {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" autofocus required>
            @if($errors->has('email'))
                <p class="invalid-feedback">{{ $errors->first('email') }}</p>
            @endif
        </label>

        <label class="block mt-3">
            <span class="text-gray-700 text-sm">{{ trans('global.login_password') }}</span>
            <input type="password" name="password" class="form-input{{ $errors->has('password') ? ' is-invalid' : '' }}" required>
            @if($errors->has('password'))
                <p class="invalid-feedback">{{ $errors->first('password') }}</p>
            @endif
        </label>

        <label class="block mt-3">
            <span class="text-gray-700 text-sm">{{ trans('cruds.global.role') }}</span>
                    <select name="role" id="role" class="form-input{{ $errors->has('role') ? 'is-invalid' : '' }}" value="{{ old('role') }}" required>
                        <option value="4">School</option>
                        <option value="3">Parent</option>
                    </select>
        </label>

        <div class="flex justify-between items-center mt-4">


            @if(Route::has('password.request'))
                <div>
                    <a class="link" href="{{ route('login') }}">{{ trans('cruds.global.loginalready') }}</a>
                </div>
            @endif
        </div>

        <div class="mt-6">
            <button type="submit" class="button">
                {{ trans('cruds.global.register') }}
            </button>
        </div>
    </form>
</div>
@endsection
