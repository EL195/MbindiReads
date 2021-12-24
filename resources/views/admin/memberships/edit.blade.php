@extends('layouts.admin')
@section('content')
<div class="main-card">
    <div class="header">
        {{ trans('global.edit') }} {{ trans('cruds.global.membership') }}
    </div>

    <form method="POST" action="{{ route("admin.memberships.update", [$membership->id]) }}" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="body">
         <div class="mb-3">
                <label for="name" class="text-xs required">{{ trans('cruds.folder.fields.name') }}</label>
                <div class="form-group">
                    <input type="text" id="name" name="name" class="{{ $errors->has('name') ? 'is-invalid' : '' }}" value="{{ old('name', $membership->name) }}" required>
                </div>
                @if($errors->has('name'))
                    <p class="invalid-feedback">{{ $errors->first('name') }}</p>
                @endif
                <span class="block">{{ trans('cruds.folder.fields.name_helper') }}</span>
            </div>
            <div class="mb-3">
                <label for="name" class="text-xs required">{{ trans('cruds.forms.descritpion') }}</label>
                <div class="form-group">
                    <textarea style="width: 100%;" id="description" name="description" class="{{ $errors->has('description') ? 'is-invalid' : '' }}" value="{{ old('description') }}"  required>
                        {{ old('name', $membership->description) }} </textarea>
                </div>
                @if($errors->has('name'))
                    <p class="invalid-feedback">{{ $errors->first('name') }}</p>
                @endif
                <span class="block">{{ trans('cruds.folder.fields.description_helper') }}</span>
            </div>
            <div class="mb-3">
                <label for="price" class="text-xs required">{{ trans('cruds.global.price') }}</label>
                <div class="form-group">
                    <input type="text" id="price" name="price" class="{{ $errors->has('price') ? 'is-invalid' : '' }}" value="{{ old('name', $membership->price) }}" required>
                </div>
                @if($errors->has('name'))
                    <p class="invalid-feedback">{{ $errors->first('name') }}</p>
                @endif
                <span class="block">{{ trans('cruds.folder.fields.name_helper') }}</span>
            </div>
            <div class="mb-3">
                <label for="type" class="text-xs required">{{ trans('cruds.global.periode') }}</label>
                <div class="form-group">
                    <select name="periode" id="periode" class="{{ $errors->has('periode') ? 'is-invalid' : '' }}" value="{{ old('periode') }}" required>
                        <option value="Annual">{{ trans('cruds.global.annual') }}</option>
                        <option value="Biannual">{{ trans('cruds.global.biannual') }}</option>
                        <option value="Quarterly">{{ trans('cruds.global.quarterly') }}</option>
                        <option value="Monthly">{{ trans('cruds.global.monthly') }}</option>
                        <option value="Weekly">{{ trans('cruds.global.weekly') }}</option>
                        <option value="Daily">{{ trans('cruds.global.daily') }}</option>
                    </select>
                </div>
                @if($errors->has('name'))
                    <p class="invalid-feedback">{{ $errors->first('name') }}</p>
                @endif
                <span class="block">{{ trans('cruds.folder.fields.name_helper') }}</span>
            </div>
             <div class="mb-3">
                <label for="type" class="text-xs required">{{ trans('cruds.global.type') }}</label>
                <div class="form-group">
                    <select name="type" id="type" class="{{ $errors->has('name') ? 'is-invalid' : '' }}" value="{{ old('name') }}" required>
                        <option value="parent">{{ trans('cruds.global.parent') }}</option>
                        <option value="school">{{ trans('cruds.global.school') }}</option>
                    </select>
                </div>
                @if($errors->has('name'))
                    <p class="invalid-feedback">{{ $errors->first('name') }}</p>
                @endif
                <span class="block">{{ trans('cruds.folder.fields.name_helper') }}</span>
            </div>
  



        </div>

        <div class="footer">
            <button type="submit" class="submit-button">{{ trans('global.update') }}</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    var uploadedFilesMap = {}
Dropzone.options.filesDropzone = {
    url: '{{ route('admin.folders.storeMedia') }}',
    maxFilesize: 2, // MB
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="files[]" value="' + response.name + '">')
      uploadedFilesMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedFilesMap[file.name]
      }
      $('form').find('input[name="files[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($folder) && $folder->files)
          var files =
            {!! json_encode($folder->files) !!}
              for (var i in files) {
              var file = files[i]
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="files[]" value="' + file.file_name + '">')
            }
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
@endsection