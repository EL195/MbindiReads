@extends('layouts.admin')
@section('content')

<div class="main-card">
    <div class="header">
        {{ trans('global.create') }} {{ trans('cruds.global.langue') }}
    </div>

    <form method="POST" action="{{ route("admin.langues.store") }}" enctype="multipart/form-data">
        @csrf
        <div class="body">
            <div class="mb-3">
                <label for="title" class="text-xs required">{{ trans('cruds.global.title') }}</label>
                <div class="form-group">
                    <input type="text" id="title" name="title" class="{{ $errors->has('title') ? 'is-invalid' : '' }}" value="{{ old('title') }}" required>
                </div>
                @if($errors->has('name'))
                    <p class="invalid-feedback">{{ $errors->first('name') }}</p>
                @endif
                <span class="block">{{ trans('cruds.folder.fields.name_helper') }}</span>
            </div>
            <div class="mb-3">
                <label for="name" class="text-xs required">{{ trans('cruds.global.code') }}</label>
                <div class="form-group">
                    <input type="text" id="code" name="code" class="{{ $errors->has('code') ? 'is-invalid' : '' }}" value="{{ old('code') }}" required>
                </div>
                @if($errors->has('code'))
                    <p class="invalid-feedback">{{ $errors->first('code') }}</p>
                @endif
                <span class="block">{{ trans('cruds.folder.fields.name_helper') }}</span>
            </div>
            <div class="mb-3" id="status">
                <label for="type" class="text-xs required">{{ trans('cruds.global.status') }}</label>
                <div class="form-group">
                    <select name="status" id="status" class="{{ $errors->has('status') ? 'is-invalid' : '' }}" value="{{ old('status') }}" required>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
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