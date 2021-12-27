<?php

namespace App\Http\Controllers\Admin;

use App\Models\Langue;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyFolderRequest;
use App\Http\Requests\StoreFolderRequest;
use App\Http\Requests\UpdateFolderRequest;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class LangueController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {

        $langues = Langue::all();
        return view('admin.langues.index', compact('langues'));
    }

    public function create()
    {
        return view('admin.langues.create');
    }

    public function store(StoreFolderRequest $request)
    {
        $langue = Langue::create($request->all());
        return redirect()->route('admin.langues.index');
    }

    public function edit($id)
    {
        return view('admin.langues.edit', [
            'langue' => Langue::query()
                ->find($id),
        ]);
    }

    public function update(UpdateFolderRequest $request, $id)
    {
        $langue = Langue::query()->find($id);
        $langue->title = $request->title;
        $langue->code = $request->code;
        $langue->status = $request->status;
        $langue->update();
        return redirect()->route('admin.langues.index');
    }


    public function destroy($id)
    {
        //dd($id);
        $langue= Langue::query()->find($id);
        $langue->delete();
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
