<?php

namespace App\Http\Controllers\Admin;

use App\Models\Agegroup;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyFolderRequest;
use App\Http\Requests\StoreFolderRequest;
use App\Http\Requests\UpdateFolderRequest;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class AgegroupController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {

        $agegroups = Agegroup::all();
        return view('admin.agegroups.index', compact('agegroups'));
    }

    public function create()
    {
        return view('admin.agegroups.create');
    }

    public function store(StoreFolderRequest $request)
    {
        $genre = Agegroup::create($request->all());
        return redirect()->route('admin.agegroups.index');
    }

    public function edit($id)
    {
        return view('admin.agegroups.edit', [
            'agegroup' => Agegroup::query()
                ->find($id),
        ]);
    }

    public function update(UpdateFolderRequest $request, $id)
    {
        $agegroup = Agegroup::query()->find($id);
        $agegroup->name = $request->name;
        $agegroup->years_start = $request->years_start;
        $agegroup->years_end = $request->years_end;
        $agegroup->update();
        return redirect()->route('admin.agegroups.index');
    }


    public function destroy($id)
    {
        //dd($id);
        $agegroup=Agegroup::query()->find($id);
        $agegroup->delete();
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
