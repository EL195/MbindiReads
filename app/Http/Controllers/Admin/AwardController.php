<?php

namespace App\Http\Controllers\Admin;

use App\Models\Award;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyFolderRequest;
use App\Http\Requests\StoreFolderRequest;
use App\Http\Requests\UpdateFolderRequest;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class AwardController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {

        $awards = Award::all();
        return view('admin.awards.index', compact('awards'));
    }

    public function create()
    {
        return view('admin.awards.create');
    }

    public function store(StoreFolderRequest $request)
    {

        $request->validate([
            //'file' => 'required|mimes:pdf|max:2048',
            'file' => 'required|mimes:png,jpg,jpeg,gif|max:2048'
            ]);
        $fileModel = new Award;

        if($request->file()) {
            $fileName = time().'_'.$request->file->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');
            $fileModel->file = time().'_'.$request->file->getClientOriginalName();
            $fileModel->file_path = '/storage/' . $filePath;
            $fileModel->name = $request->name;
            $fileModel->description = $request->description;
            $fileModel->note = $request->note;
            $fileModel->order = $request->order;
            $fileModel->save();
        }
        else{
            $fileModel->name = $request->name;
            $fileModel->description = $request->description;
            $fileModel->note = $request->note;
            $fileModel->order = $request->order;
            $fileModel->save();
        }
        return redirect()->route('admin.awards.index');
    }

    public function edit($id)
    {
        return view('admin.awards.edit', [
            'award' => Award::query()
                ->find($id),
        ]);
    }

    public function update(UpdateFolderRequest $request, $id)
    {
        if($request->file()) {
            $award = Award::query()->find($id);
            $fileName = time().'_'.$request->file->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');
            $award->file = time().'_'.$request->file->getClientOriginalName();
            $award->file_path = '/storage/' . $filePath;
            $award->name = $request->name;
            $award->note = $request->note;
            $award->order = $request->order;
            $award->description = $request->description;
            $award->update();
        }
        else{
        $award = Award::query()->find($id);
        $award->name = $request->name;
        $award->note = $request->note;
        $award->order = $request->order;
        $award->description = $request->description;
        $award->update();
        }
        return redirect()->route('admin.awards.index');
    }


    public function destroy($id)
    {
        //dd($id);
        $award=Award::query()->find($id);
        $award->delete();
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
