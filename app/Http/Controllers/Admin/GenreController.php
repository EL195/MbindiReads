<?php

namespace App\Http\Controllers\Admin;

use App\Models\Genre;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyFolderRequest;
use App\Http\Requests\StoreFolderRequest;
use App\Http\Requests\UpdateFolderRequest;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class GenreController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {

        $genres = Genre::all();
        return view('admin.genres.index', compact('genres'));
    }

    public function create()
    {
        return view('admin.genres.create');
    }

    public function store(StoreFolderRequest $request)
    {
        $genre = Genre::create($request->all());
        return redirect()->route('admin.genres.index');
    }

    public function edit($id)
    {
        return view('admin.genres.edit', [
            'genre' => Genre::query()
                ->find($id),
        ]);
    }

    public function update(UpdateFolderRequest $request, $id)
    {
        $genre = Genre::query()->find($id);
        $genre->name = $request->name;
        $genre->description = $request->description;
        $genre->update();
        return redirect()->route('admin.genres.index');
    }


    public function destroy($id)
    {
        //dd($id);
        $genre=Genre::query()->find($id);
        $genre->delete();
        return back();
    }

    public function massDestroy(MassDestroyFolderRequest $request)
    {
        Genre::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('folder_create') && Gate::denies('folder_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Genre();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
