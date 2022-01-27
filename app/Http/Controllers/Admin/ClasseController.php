<?php

namespace App\Http\Controllers\Admin;

use App\Models\Classe;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyFolderRequest;
use App\Http\Requests\StoreFolderRequest;
use App\Http\Requests\UpdateFolderRequest;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class ClasseController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {

        $userId = Auth::id();
        $classes = Classe::query()->where("user_id", $userId)->get();
        $count = Classe::query()->where("user_id", $userId)->count();
       // dd($count);
        return view('admin.classes.index', compact('classes', 'count'));
    }

    public function create()
    {
        return view('admin.classes.create');
    }

    public function store(StoreFolderRequest $request)
    {
        $classe = new Classe;
        $userId = Auth::id();
        //dd($userId);
        $classe->user_id = $userId;
        $classe->name = $request->name;
        $classe->save();
        return redirect()->route('admin.classes.index');
    }

    public function edit($id)
    {
        return view('admin.classes.edit', [
            'classe' => Classe::query()
                ->find($id),
        ]);
    }

    public function update(UpdateFolderRequest $request, $id)
    {
        $classe = Classe::query()->find($id);
        $classe->name = $request->name;
        $classe->update();
        return redirect()->route('admin.classes.index');
    }


    public function destroy($id)
    {
        //dd($id);
        $classe=Classe::query()->find($id);
        $classe->delete();
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
