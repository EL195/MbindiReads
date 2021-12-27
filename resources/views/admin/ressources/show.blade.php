@extends('layouts.admin')
@section('content')
<div class="main-card">
    <div class="header">
        {{ trans('global.show') }} {{ trans('cruds.global.ressource') }}
    </div>

    <div class="body">
        <div class="block pb-4">
            <a class="btn-md btn-gray" href="{{ route('admin.ressources.index') }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>
        <table class="striped bordered show-table">
            <tbody>
                <tr>
                    <th>
                        {{ trans('cruds.folder.fields.id') }}
                    </th>
                    <td>
                        {{ $ressource->id }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('cruds.folder.fields.name') }}
                    </th>
                    <td>
                        {{ $ressource->name }}
                    </td>
                </tr>
                <tr>
                    <th>
                          {{ trans('cruds.global.level') }}
                    </th>
                    <td>
                        {{ $ressource->level->name ?? '' }}
                    </td>
                </tr>
                <tr>
                    <th>
                         {{ trans('cruds.global.ageroupge') }}
                    </th>
                    <td>
                        {{ $ressource->ageroup->name ?? '' }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('cruds.global.subject') }}
                    </th>
                    <td>
                        {{ $ressource->subject->name ?? '' }}
                    </td>
                </tr>
                <tr>
                    <th>
                         {{ trans('cruds.global.genre') }}
                    </th>
                    <td>
                        {{ $ressource->genre->name ?? '' }}
                    </td>
                </tr>
                 <tr>
                    <th>
                         {{ trans('cruds.global.theme') }}
                    </th>
                    <td>
                        {{ $ressource->theme->name ?? '' }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('cruds.global.pdf') }}
                    </th>
                    <td>
                                    <a href="{{ $ressource->file_path }}" target="_blank">
                                        {{ trans('cruds.global.view_pdf') }}
                                    </a>
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('cruds.global.image') }}
                    </th>
                    <td>
                                  @foreach($ressource->files as $key => $media)
                                    <a href="{{ $media->getUrl() }}" target="_blank">
                                        {{ trans('cruds.global.view_image') }}
                                    </a>
                                @endforeach
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="block pt-4">
            <a style="background: green;color:white;" class="btn-md btn-danger" href="{{ route('admin.quiz.index', ['quiz' => $ressource->id]) }}">
                {{ trans('cruds.global.view_quiz') }}
            </a>
        </div>
    </div>
</div>
@endsection