@extends('layouts.admin')
@section('content')

<div class="main-card">
    <div class="header">
        {{ trans('global.create') }} {{ trans('cruds.global.ressource') }}
    </div>

    <form method="POST" action="{{ route("admin.ressources.store") }}" enctype="multipart/form-data">
        @csrf
        <div class="body">
            <div class="mb-3">
                <label for="type" class="text-xs required">{{ trans('cruds.global.ChooseB') }}</label>
                <div class="form-group">
                    <select name="choose" id="choose" class="{{ $errors->has('choose') ? 'is-invalid' : '' }}" value="{{ old('choose') }}"  >
                        <option value="0">{{ trans('cruds.global.leveled') }}</option>
                        <option value="1">{{ trans('cruds.global.agegrouponly') }}</option>
                        <option value="3">{{ trans('cruds.global.agegroupandlevel') }}</option>
                    </select>
                </div>
                @if($errors->has('agegroup_id'))
                    <p class="invalid-feedback">{{ $errors->first('agegroup_id') }}</p>
                @endif
                <span class="block">{{ trans('cruds.folder.fields.name_helper') }}</span>
            </div>


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
                <label for="author" class="text-xs required">{{ trans('cruds.global.author') }}</label>
                <div class="form-group">
                    <input type="text" id="author" name="author" class="{{ $errors->has('author') ? 'is-invalid' : '' }}" value="{{ old('author') }}" required>
                </div>
                @if($errors->has('author'))
                    <p class="invalid-feedback">{{ $errors->first('author') }}</p>
                @endif
               
            </div>
            <div class="mb-3">
                <label for="author" class="text-xs required">{{ trans('cruds.global.pages_number') }}</label>
                <div class="form-group">
                    <input type="number" id="pages_number" name="pages_number" class="{{ $errors->has('pages_number') ? 'is-invalid' : '' }}" value="{{ old('pages_number') }}" required>
                </div>
                @if($errors->has('pages_number'))
                    <p class="invalid-feedback">{{ $errors->first('page_number') }}</p>
                @endif
                
            </div>
            <div class="mb-3">
                <label for="type" class="text-xs required">{{ trans('cruds.global.langue') }}</label>
                <div class="form-group">
                    <select name="langue_id" id="langue_id" class="{{ $errors->has('langue_id') ? 'is-invalid' : '' }}" value="{{ old('langue_id') }}" required >
                        <option value="1">{{ trans('cruds.global.default') }}</option>
                        @foreach($langues as $key => $langue)
                        <option value="{{ $langue->id ?? '' }}">{{ $langue->title ?? '' }}</option>
                        @endforeach
                    </select>
                </div>
                @if($errors->has('langue_id'))
                    <p class="invalid-feedback">{{ $errors->first('langue_id') }}</p>
                @endif
                <span class="block">{{ trans('cruds.folder.fields.name_helper') }}</span>
            </div>


            <div class="mb-3" id="agegroupid">
                <label for="type" class="text-xs required">{{ trans('cruds.global.age') }}</label>
                <div class="form-group">
                    <select name="agegroup_id" id="agegroup_id" class="{{ $errors->has('agegroup_id') ? 'is-invalid' : '' }}" value="{{ old('agegroup_id') }}"  >
                        <option value="1">{{ trans('cruds.global.default') }}</option>
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

            <div class="mb-3" id="subjectid">
                <label for="type" class="text-xs required">{{ trans('cruds.global.subject') }}</label>
                <div class="form-group">
                    <select name="subject_id" id="subject_id" class="{{ $errors->has('subject_id') ? 'is-invalid' : '' }}" value="{{ old('subject_id') }}" >
                        @foreach($subjects as $key => $subject)
                        <option value="{{ $subject->id ?? '' }}">{{ $subject->name ?? '' }}</option>
                        @endforeach
                    </select>
                </div>
                @if($errors->has('subject_id'))
                    <p class="invalid-feedback">{{ $errors->first('subject_id') }}</p>
                @endif
                <span class="block">{{ trans('cruds.folder.fields.name_helper') }}</span>
            </div>
            <div class="mb-3" id="genreid">
                <label for="type" class="text-xs required">{{ trans('cruds.global.genre') }}</label>
                <div class="form-group">
                    <select name="genre_id" id="genre_id" class="{{ $errors->has('genre_id') ? 'is-invalid' : '' }}" value="{{ old('genre_id') }}" >
                        @foreach($genres as $key => $genre)
                        <option value="{{ $genre->id ?? '' }}">{{ $genre->name ?? '' }}</option>
                        @endforeach
                    </select>
                </div>
                @if($errors->has('genre_id'))
                    <p class="invalid-feedback">{{ $errors->first('genre_id') }}</p>
                @endif
                <span class="block">{{ trans('cruds.folder.fields.name_helper') }}</span>
            </div>
            <div class="mb-3" id="themeid">
                <label for="type" class="text-xs required">{{ trans('cruds.global.theme') }}</label>
                <div class="form-group">
                    <select name="theme_id" id="theme_id" class="{{ $errors->has('theme_id') ? 'is-invalid' : '' }}" value="{{ old('theme_id') }}" >
                        @foreach($themes as $key => $theme)
                        <option value="{{ $theme->id ?? '' }}">{{ $theme->name ?? '' }}</option>
                        @endforeach
                    </select>
                </div>
                @if($errors->has('theme_id'))
                    <p class="invalid-feedback">{{ $errors->first('theme_id') }}</p>
                @endif
                <span class="block">{{ trans('cruds.folder.fields.name_helper') }}</span>
            </div>
            <div class="mb-3" id="levelid">
                <label for="type" class="text-xs required">{{ trans('cruds.global.level') }}</label>
                <div class="form-group">
                    <select name="level_id" id="level_id" class="{{ $errors->has('level_id') ? 'is-invalid' : '' }}" value="{{ old('level_id') }}" >
                        @foreach($levels as $key => $level)
                        <option value="{{ $level->id ?? '' }}">{{ $level->name ?? '' }}</option>
                        @endforeach
                    </select>
                </div>
                @if($errors->has('level_id'))
                    <p class="invalid-feedback">{{ $errors->first('level_id') }}</p>
                @endif
                <span class="block">{{ trans('cruds.folder.fields.name_helper') }}</span>
            </div>
  
            <div class="mb-3">
                <label for="name" class="text-xs required">{{ trans('cruds.forms.descritpion') }}</label>
                <div class="form-group">
                    <textarea style="width: 100%;" id="description" name="description" class="{{ $errors->has('description') ? 'is-invalid' : '' }}" value="{{ old('description') }}"  required>
                   </textarea>
                </div>
                @if($errors->has('name'))
                    <p class="invalid-feedback">{{ $errors->first('name') }}</p>
                @endif
                <span class="block">{{ trans('cruds.folder.fields.description_helper') }}</span>
            </div>
            <div class="mb-3">
                <label for="files-dropzone" class="text-xs">{{ trans('cruds.folder.fields.files') }}</label>

                <div class="form-group">
                    <div class="needsclick dropzone w-full{{ $errors->has('files') ? ' is-invalid' : '' }}" id="files-dropzone">
                    </div>
                </div>
                @if($errors->has('files'))
                    <p class="invalid-feedback">{{ $errors->first('files') }}</p>
                @endif
                <span class="block">{{ trans('cruds.folder.fields.files_helper') }}</span>
            </div>
            <div class="mb-3">
                <label for="file" class="text-xs required">{{ trans('cruds.global.file') }}</label>
                <div class="form-group">
                    <input type="file" id="file" name="file" class="{{ $errors->has('file') ? 'is-invalid' : '' }}" value="{{ old('file') }}" required>
                </div>
                @if($errors->has('file'))
                    <p class="invalid-feedback">{{ $errors->first('file') }}</p>
                @endif
                <span class="block">{{ trans('cruds.folder.fields.file_helper') }}</span>
            </div>

        </div>

        <div class="footer">
            <button type="submit" class="submit-button">{{ trans('global.save') }}</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> 

<script>

$('#choose').on('change', function() {
    if(document.getElementById("choose").value==1){
        /*  Show */
        document.getElementById("agegroupid").style.display="block";
        /*  Hide */         
        document.getElementById("levelid").style.display="none";
        document.getElementById("genreid").style.display="none";
        document.getElementById("subjectid").style.display="none";
        document.getElementById("themeid").style.display="none";
    }
    if(document.getElementById("choose").value==0){
        /*  Show */
        document.getElementById("levelid").style.display="block";
        document.getElementById("genreid").style.display="block";
        document.getElementById("subjectid").style.display="block";
        document.getElementById("themeid").style.display="block";
        /*  Hide */         
        document.getElementById("agegroupid").style.display="none";
    }
    if(document.getElementById("choose").value==3){
        /*  Show */
        document.getElementById("levelid").style.display="block";
        document.getElementById("genreid").style.display="block";
        document.getElementById("subjectid").style.display="block";
        document.getElementById("themeid").style.display="block";
        document.getElementById("agegroupid").style.display="block";

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