@extends('layouts.admin')
@section('content')

<div class="main-card">
    <div class="header">
        {{ trans('global.create') }} {{ trans('cruds.global.payement') }} 
    </div>

    <form method="POST" action="{{ route("admin.pay.store") }}" enctype="multipart/form-data">
        @csrf
        <div class="body">

            <div class="mb-3">
                <label for="type" class="text-xs required">{{ trans('cruds.global.payement_type') }}</label>
                <div class="form-group">
                    <select name="payement" id="payement" class="{{ $errors->has('payement') ? 'is-invalid' : '' }}" value="{{ old('payement') }}"  >
                        <option value="offline">{{ trans('cruds.global.offline') }}</option>
                        <option value="online">{{ trans('cruds.global.online') }}</option>
                    </select>
                </div>
                @if($errors->has('payement'))
                    <p class="invalid-feedback">{{ $errors->first('payement') }}</p>
                @endif
                <span class="block">{{ trans('cruds.folder.fields.name_helper') }}</span>
            </div>
            @if($role=="School")
             <div class="mb-3" id="status">
                <label for="type" class="text-xs required">{{ trans('cruds.global.class') }}</label>
                <div class="form-group">
                    <select name="classe" id="classe" class="{{ $errors->has('classe') ? 'is-invalid' : '' }}" value="{{ old('classe') }}" required>
                        @foreach($classes as $key => $classe)
                        <option value="{{ $classe->id ?? '' }}">{{ $classe->name ?? '' }}</option>
                        @endforeach

                        @foreach($paidclasses as $key => $item)
                            @if($item)
                            <option value="{{ $item->id ?? '' }}">{{ $item->name ?? '' }} -- {{ trans('cruds.global.renewal') }} --</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                @if($errors->has('classe'))
                    <p class="invalid-feedback">{{ $errors->first('classe') }}</p>
                @endif
                <span class="block">{{ trans('cruds.folder.fields.name_helper') }}</span>
            </div>
            @else
             <div class="mb-3" id="status">
                <label for="type" class="text-xs required">{{ trans('cruds.global.class') }}</label>
                <div class="form-group">
                    <select name="student" id="student" class="{{ $errors->has('student') ? 'is-invalid' : '' }}" value="{{ old('student') }}" required>
                        @foreach($students as $key => $student)
                        <option value="{{ $student->id ?? '' }}">{{ $student->first_name ?? '' }}</option>
                        @endforeach
                        @foreach($studentspaid as $key => $item)
                            @if($item)
                            <option value="{{ $item->id ?? '' }}">{{ $item->first_name ?? '' }} -- {{ trans('cruds.global.renewal') }} --</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                @if($errors->has('classe'))
                    <p class="invalid-feedback">{{ $errors->first('classe') }}</p>
                @endif
                <span class="block">{{ trans('cruds.folder.fields.name_helper') }}</span>
            </div>
            @endif

            <div class="mb-3" id="status">
                <label for="type" class="text-xs required">{{ trans('cruds.global.membership') }}</label>
                <div class="form-group">
                    <select name="membership" id="membership" class="{{ $errors->has('membership') ? 'is-invalid' : '' }}" value="{{ old('membership') }}" required>
                        @foreach($memberships as $key => $membership)
                        <option value="{{ $membership->id ?? '' }}">{{ $membership->name ?? '' }} --- {{$membership->price}} XAF ({{ $membership->periode}} jours)</option>
                        @endforeach
                    </select>
                </div>
                @if($errors->has('classe'))
                    <p class="invalid-feedback">{{ $errors->first('classe') }}</p>
                @endif
                <span class="block">{{ trans('cruds.folder.fields.name_helper') }}</span>
            </div>

        </div>

        <div class="footer">
            <button type="submit" class="submit-button">{{ trans('cruds.global.pay') }}</button>
        </div>
    </form>
</div>
@endsection
