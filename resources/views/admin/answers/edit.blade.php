@extends('layouts.admin')
@section('content')
<div class="main-card">
    <div class="header">
        {{ trans('global.edit') }} {{ trans('cruds.global.answer') }}
    </div>

    <form method="POST" action="{{ route("admin.answers.update", [$answer->id]) }}" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="body">
                        <div class="mb-3" >
                <label for="type" class="text-xs required">{{ trans('cruds.global.type') }}</label>
                <div class="form-group">
                    <select name="type" id="type" class="{{ $errors->has('type') ? 'is-invalid' : '' }}" value="{{ old('type') }}" required >
                        <option value="text">{{ trans('cruds.global.text') }}</option>
                         <option value="image">{{ trans('cruds.global.image') }}</option>
                    </select>
                </div>
                @if($errors->has('type'))
                    <p class="invalid-feedback">{{ $errors->first('type') }}</p>
                @endif
                <span class="block">{{ trans('cruds.folder.fields.name_helper') }}</span>
            </div>

            <div class="mb-3" id="textid" style="display:none;">
                <label for="title" class="text-xs required">{{ trans('cruds.global.title') }}</label>
                <div class="form-group">
                    <input type="text" id="title" name="title" class="{{ $errors->has('title') ? 'is-invalid' : '' }}" value="{{ old('title') }}" required>
                </div>
                @if($errors->has('title'))
                    <p class="invalid-feedback">{{ $errors->first('title') }}</p>
                @endif
                <span class="block">{{ trans('cruds.folder.fields.name_helper') }}</span>
            </div>
            <div class="mb-3" id="imageid" style="display:none;">
                <label for="file" class="text-xs required">{{ trans('cruds.global.file') }}</label>
                <div class="form-group">
                    <input type="file" id="file" name="file" class="{{ $errors->has('file') ? 'is-invalid' : '' }}" value="{{ old('file') }}" required>
                </div>
                @if($errors->has('file'))
                    <p class="invalid-feedback">{{ $errors->first('file') }}</p>
                @endif
                <span class="block">{{ trans('cruds.folder.fields.file_helper') }}</span>
            </div>

            <div class="mb-3" id="rep" style="display:none;">
                <label for="choose" class="text-xs required">{{ trans('cruds.global.trueRep') }}</label>
                <div class="form-group">
                    <select name="choose" id="choose" class="{{ $errors->has('choose') ? 'is-invalid' : '' }}" value="{{ old('choose') }}" required >
                        <option value="1">{{ trans('cruds.global.true') }}</option>
                        <option value="0">{{ trans('cruds.global.false') }}</option>
                    </select>
                </div>
                @if($errors->has('type'))
                    <p class="invalid-feedback">{{ $errors->first('type') }}</p>
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

$('#type').on('change', function() {
    if(document.getElementById("type").value=="text"){
        document.getElementById("textid").style.display="block";
        document.getElementById("imageid").style.display="none";
         document.getElementById("rep").style.display="block";
    }
    if(document.getElementById("type").value=="image"){
         document.getElementById("imageid").style.display="block";
         document.getElementById("rep").style.display="block";
          document.getElementById("textid").style.display="none";
    }

});



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