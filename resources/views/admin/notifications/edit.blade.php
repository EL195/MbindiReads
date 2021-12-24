@extends('layouts.admin')
@section('content')
<div class="main-card">
    <div class="header">
        {{ trans('global.edit') }} {{ trans('cruds.global.level') }}
    </div>

    <form method="POST" action="{{ route("admin.levels.update", [$level->id]) }}" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="body">
           <div class="mb-3">
                <label for="name" class="text-xs required">{{ trans('cruds.folder.fields.name') }}</label>
                <div class="form-group">
                    <input type="text" id="name" name="name" class="{{ $errors->has('name') ? 'is-invalid' : '' }}" value="{{ old('name', $level->name) }}" required>
                </div>
                @if($errors->has('name'))
                    <p class="invalid-feedback">{{ $errors->first('name') }}</p>
                @endif
                <span class="block">{{ trans('cruds.folder.fields.name_helper') }}</span>
            </div>
            <div class="mb-3">
                <label for="order" class="text-xs required">{{ trans('cruds.global.order') }}</label>
                <div class="form-group">
                    <input type="number" id="order" name="order" class="{{ $errors->has('order') ? 'is-invalid' : '' }}" value="{{ old('name', $level->order) }}" required>
                </div>
                @if($errors->has('order'))
                    <p class="invalid-feedback">{{ $errors->first('order') }}</p>
                @endif
                <span class="block">{{ trans('cruds.folder.fields.name_helper') }}</span>
            </div>
            <div class="mb-3">
                <label for="type" class="text-xs required">{{ trans('cruds.global.periode') }}</label>
                <div class="form-group">
                    <select name="agegroup_id" id="agegroup_id" class="{{ $errors->has('agegroup_id') ? 'is-invalid' : '' }}"  required>
                         <option value="{{ $level->agegroup->id ?? '' }}">{{ $level->agegroup->name ?? '' }}</option>
                        @foreach($agegroups as $key => $agegroup)
                        <option value="{{ $agegroup->id ?? '' }}">{{ $agegroup->name ?? '' }}</option>
                        @endforeach
                    </select>
                </div>
                @if($errors->has('agegroup_id'))
                    <p class="invalid-feedback">{{ $errors->first('agegroup_id') }}</p>
                @endif
                <span class="block">{{ trans('cruds.folder.fields.name_helper') }}</span>
            </div>
  
            <div class="mb-3">
                <label for="name" class="text-xs required">{{ trans('cruds.forms.descritpion') }}</label>
                <div class="form-group">
                    <textarea style="width: 100%;" id="description" name="description" class="{{ $errors->has('description') ? 'is-invalid' : '' }}" value="{{ old('description') }}"  required>
                   {{ $level->description ?? '' }}
                   </textarea>
                </div>
                @if($errors->has('name'))
                    <p class="invalid-feedback">{{ $errors->first('name') }}</p>
                @endif
                <span class="block">{{ trans('cruds.folder.fields.description_helper') }}</span>
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