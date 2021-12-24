<?php

namespace App\Http\Controllers\Admin;

use App\Models\Subject;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyFolderRequest;
use App\Http\Requests\StoreFolderRequest;
use App\Http\Requests\UpdateFolderRequest;
use App\Role;
use App\User;
use App\Folder;
use App\Project;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class SubjectController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {

        $subjects = Subject::all();
        return view('admin.subjects.index', compact('subjects'));
    }

    public function create()
    {
        return view('admin.subjects.create');
    }

    public function store(StoreFolderRequest $request)
    {
        $subject = Subject::create($request->all());
        return redirect()->route('admin.subjects.index');
    }

    public function edit($id)
    {
        return view('admin.subjects.edit', [
            'subject' => Subject::query()
                ->find($id),
        ]);
    }

    public function update(UpdateFolderRequest $request, $id)
    {
        $subject = Subject::query()->find($id);
        $subject->name = $request->name;
        $subject->description = $request->description;
        $subject->update();
        return redirect()->route('admin.subjects.index');
    }


    public function destroy($id)
    {
        //dd($id);
        $subject=Subject::query()->find($id);
        $subject->delete();
        return back();
    }

    public function massDestroy(MassDestroyFolderRequest $request)
    {
        Folder::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('folder_create') && Gate::denies('folder_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Folder();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
