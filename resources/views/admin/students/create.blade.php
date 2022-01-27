@extends('layouts.admin')
@section('content')

<div class="main-card">
    <div class="header">
        {{ trans('global.create') }} {{ trans('cruds.global.student') }}
    </div>

    <form method="POST" action="{{ route("admin.students.store") }}" enctype="multipart/form-data">
        @csrf
        <div class="body">
            <div class="mb-3">
                <label for="title" class="text-xs required">{{ trans('cruds.global.last_name') }}</label>
                <div class="form-group">
                    <input type="text" id="last_name" name="last_name" class="{{ $errors->has('last_name') ? 'is-invalid' : '' }}" value="{{ old('last_name') }}" required>
                </div>
                @if($errors->has('last_name'))
                    <p class="invalid-feedback">{{ $errors->first('last_name') }}</p>
                @endif
                <span class="block">{{ trans('cruds.folder.fields.name_helper') }}</span>
            </div>
            <div class="mb-3">
                <label for="title" class="text-xs required">{{ trans('cruds.global.first_name') }}</label>
                <div class="form-group">
                    <input type="text" id="first_name" name="first_name" class="{{ $errors->has('first_name') ? 'is-invalid' : '' }}" value="{{ old('first_name') }}" required>
                </div>
                @if($errors->has('first_name'))
                    <p class="invalid-feedback">{{ $errors->first('first_name') }}</p>
                @endif
                <span class="block">{{ trans('cruds.folder.fields.name_helper') }}</span>
            </div>
            <div class="mb-3">
                <label for="title" class="text-xs required">{{ trans('cruds.global.username') }}</label>
                <div class="form-group">
                    <input type="text" id="username" name="username" class="{{ $errors->has('username') ? 'is-invalid' : '' }}" value="{{ old('username') }}" required>
                </div>
                @if($errors->has('username'))
                    <p class="invalid-feedback">{{ $errors->first('username') }}</p>
                @endif
                <span class="block">{{ trans('cruds.folder.fields.name_helper') }}</span>
            </div>
            <div class="mb-3">
                <label for="title" class="text-xs required">{{ trans('cruds.global.password') }}</label>
                <div class="form-group">
                    <input type="password" id="password" name="password" class="{{ $errors->has('password') ? 'is-invalid' : '' }}" value="{{ old('password') }}" required>
                </div>
                @if($errors->has('password'))
                    <p class="invalid-feedback">{{ $errors->first('password') }}</p>
                @endif
                <span class="block">{{ trans('cruds.folder.fields.name_helper') }}</span>
            </div>

            <div class="mb-3" id="status">
                <label for="type" class="text-xs required">{{ trans('cruds.global.langue') }}</label>
                <div class="form-group">
                    <select name="langue" id="langue" class="{{ $errors->has('langue') ? 'is-invalid' : '' }}" value="{{ old('langue') }}" required>
                        @foreach($langues as $key => $langue)
                        <option value="{{ $langue->id ?? '' }}">{{ $langue->title ?? '' }}</option>
                        @endforeach
                    </select>
                </div>
                @if($errors->has('status'))
                    <p class="invalid-feedback">{{ $errors->first('status') }}</p>
                @endif
                <span class="block">{{ trans('cruds.folder.fields.name_helper') }}</span>
            </div>

            <div class="mb-3" id="status">
                <label for="type" class="text-xs required">{{ trans('cruds.global.age') }}</label>
                <div class="form-group">
                    <select name="age" id="age" class="{{ $errors->has('age') ? 'is-invalid' : '' }}" value="{{ old('age') }}" required>
                        @foreach($ages as $key => $age)
                        <option value="{{ $age->id ?? '' }}">{{ $age->name ?? '' }}</option>
                        @endforeach
                    </select>
                </div>
                @if($errors->has('status'))
                    <p class="invalid-feedback">{{ $errors->first('status') }}</p>
                @endif
                <span class="block">{{ trans('cruds.folder.fields.name_helper') }}</span>
            </div>

        </div>

        <div class="footer">
            <button type="submit" class="submit-button">{{ trans('global.save') }}</button>
        </div>
    </form>
</div>
@endsection
