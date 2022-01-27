@extends('layouts.admin')
@section('content')

<div class="main-card">
    <div class="header">
        {{ trans('global.create') }} {{ trans('cruds.global.addAgegroup') }} 
    </div>

    <form method="POST" action="{{ route("admin.agegroups.store") }}" enctype="multipart/form-data">
        @csrf
        <div class="body">

        
            <div class="mb-3">
                <label for="name" class="text-xs required">{{ trans('cruds.folder.fields.name') }}</label>
                <div class="form-group">
                    <input type="text" id="name" name="name" class="{{ $errors->has('name') ? 'is-invalid' : '' }}" value="{{ old('name') }}" required>
                </div>
                @if($errors->has('name'))
                    <p class="invalid-feedback">{{ $errors->first('name') }}</p>
                @endif
                <span class="block">{{ trans('cruds.folder.fields.name_helper') }}</span>
            </div>
            <div class="mb-3">
                <label for="name" class="text-xs required">{{ trans('cruds.global.years_start') }}</label>
                <div class="form-group">
                    <input type="number" id="years_start" name="years_start" class="{{ $errors->has('name') ? 'is-invalid' : '' }}" value="{{ old('name') }}" required>
                </div>
                @if($errors->has('name'))
                    <p class="invalid-feedback">{{ $errors->first('years_start') }}</p>
                @endif
                <span class="block">{{ trans('cruds.folder.fields.name_helper') }}</span>
            </div>
            <div class="mb-3">
                <label for="name" class="text-xs required">{{ trans('cruds.global.years_end') }}</label>
                <div class="form-group">
                    <input type="number" id="years_end" name="years_end" class="{{ $errors->has('name') ? 'is-invalid' : '' }}" value="{{ old('name') }}" required>
                </div>
                @if($errors->has('name'))
                    <p class="invalid-feedback">{{ $errors->first('years_end') }}</p>
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