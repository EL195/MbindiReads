@extends('layouts.admin')
@section('content')
<div class="main-card">
    <div class="header">
        {{ trans('global.edit') }} {{ trans('cruds.global.quiz') }}
    </div>

    <form method="POST" action="{{ route("admin.quiz.update", [$quiz->id]) }}" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="body">
            <div class="mb-3">
                <label for="title" class="text-xs required">{{ trans('cruds.global.title') }}</label>
                <div class="form-group">
                    <input type="text" id="title" name="title" class="{{ $errors->has('title') ? 'is-invalid' : '' }}" value="{{ old('title', $quiz->title) }}" required>
                </div>
                @if($errors->has('title'))
                    <p class="invalid-feedback">{{ $errors->first('title') }}</p>
                @endif
                <span class="block">{{ trans('cruds.folder.fields.name_helper') }}</span>
            </div>
            <div class="mb-3">
                <label for="points" class="text-xs required">{{ trans('cruds.global.points') }}</label>
                <div class="form-group">
                    <input type="number" id="points" name="points" class="{{ $errors->has('points') ? 'is-invalid' : '' }}" value="{{ old('points', $quiz->points) }}" required>
                </div>
                @if($errors->has('points'))
                    <p class="invalid-feedback">{{ $errors->first('points') }}</p>
                @endif
                <span class="block">{{ trans('cruds.folder.fields.name_helper') }}</span>
            </div>
            <div class="mb-3">
                <label for="total_questions" class="text-xs required">{{ trans('cruds.global.total_questions') }}</label>
                <div class="form-group">
                    <input type="number" id="total_questions" name="total_questions" class="{{ $errors->has('total_questions') ? 'is-invalid' : '' }}"  value="{{ old('total_questions', $quiz->total_questions) }}" required>
                </div>
                @if($errors->has('total_questions'))
                    <p class="invalid-feedback">{{ $errors->first('total_questions') }}</p>
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