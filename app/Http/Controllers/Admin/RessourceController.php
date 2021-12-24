<?php

namespace App\Http\Controllers\Admin;

use App\Models\Level;
use App\Models\Agegroup;
use App\Models\Subject;
use App\Models\Genre;
use App\Models\Ressource;
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
use Illuminate\Support\Facades\Storage;

class RessourceController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {

        $ressources = Ressource::query()->with("agegroup", "genre", "subject", "theme", "level")->get();
       // dd($ressources);
        return view('admin.ressources.index', compact('ressources'));
    }

    public function create()
    {
        $agegroups = Agegroup::all();
        $genres = Genre::all();
        $themes = Theme::all();
        $subjects = Subject::all();
        $levels = Level::all();
        return view('admin.ressources.create', compact(
            'agegroups',
            'genres',
            'themes',
            'subjects',
            'levels'
        )
        );
    }

    public function store(StoreFolderRequest $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf|max:2048',
            //'image' => 'required|mimes:png,jpg,jpeg,gif|max:2048'
            ]);

            $fileModel = new Ressource;
    
            if($request->file()) {
                $fileName = time().'_'.$request->file->getClientOriginalName();
               // $fileName1 = time().'_'.$request->image->getClientOriginalName();
                $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');
              //  $filePath1 = $request->file('file')->storeAs('uploads', $fileName1, 'public');
                $fileModel->file = time().'_'.$request->file->getClientOriginalName();
               // $fileModel->image = $filePath1;
                $fileModel->file_path = '/storage/' . $filePath;

                $fileModel->name = $request->name;
                $fileModel->description = $request->description;
                $fileModel->pages_number = $request->pages_number;
                $fileModel->author = $request->author;
                $fileModel->agegroup_id = $request->agegroup_id;
                $fileModel->genre_id = $request->genre_id;
                $fileModel->subject_id = $request->subject_id;
                $fileModel->theme_id = $request->theme_id;
                $fileModel->level_id = $request->level_id;
                $fileModel->save();

                



            foreach ($request->input('files', []) as $file) {
                $fileModel->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('files');
            }
    
            if ($media = $request->input('ck-media', false)) {
                Media::whereIn('id', $media)->update(['model_id' => $fileModel->id]);
            }
    

                return redirect()->route('admin.ressources.index');
            }

    }

    public function edit($id)
    {
        return view('admin.ressources.edit', [
            'ressource' => Ressource::query()->find($id),
            'agegroups' =>  Agegroup::all(),
            'genres' =>  Genre::all(),
             'themes' => Theme::all(),
            'subjects' => Subject::all(),
            'levels' => Level::all()
        ]);
    }

    public function update(UpdateFolderRequest $request, $id)
    {
        $ressource = Ressource::query()->find($id);

        $ressource->name = $request->name;
        $ressource->description = $request->description;
        $ressource->pages_number = $request->pages_number;
        $ressource->author = $request->author;
        $ressource->agegroup_id = $request->agegroup_id;
        $ressource->genre_id = $request->genre_id;
        $ressource->subject_id = $request->subject_id;
        $ressource->theme_id = $request->theme_id;
        $ressource->level_id = $request->level_id;
        $ressource->update();


        if (count($ressource->files) > 0) {
            foreach ($ressource->files as $media) {
                if (!in_array($media->file_name, $request->input('files', []))) {
                    $media->delete();
                }
            }
        }

        $media = $ressource->files->pluck('file_name')->toArray();
        foreach ($request->input('files', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $ressource->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('files');
            }
        }
        return redirect()->route('admin.ressource.index');
    }

    public function show(Ressource $ressource)
    {
      // $ressource->load('ressource');
        return view('admin.ressources.show', compact('ressource'));
    }


    public function destroy($id)
    {
        //dd($id);
        $ressource = Ressource::query()->find($id);
        $ressource->delete();
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
