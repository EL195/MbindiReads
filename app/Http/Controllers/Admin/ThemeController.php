<?php

namespace App\Http\Controllers\Admin;

use App\Models\Theme;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyFolderRequest;
use App\Http\Requests\StoreFolderRequest;
use App\Http\Requests\UpdateFolderRequest;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class ThemeController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {

        $themes = Theme::all();
        return view('admin.themes.index', compact('themes'));
    }

    public function create()
    {
        return view('admin.themes.create');
    }

    public function store(StoreFolderRequest $request)
    {
        $theme = Theme::create($request->all());
        return redirect()->route('admin.themes.index');
    }

    public function edit($id)
    {
        return view('admin.themes.edit', [
            'theme' => Theme::query()
                ->find($id),
        ]);
    }

    public function update(UpdateFolderRequest $request, $id)
    {
        $theme = Theme::query()->find($id);
        $theme->name = $request->name;
        $theme->description = $request->description;
        $theme->update();
        return redirect()->route('admin.themes.index');
    }


    public function destroy($id)
    {
        //dd($id);
        $theme= Theme::query()->find($id);
        $theme->delete();
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
