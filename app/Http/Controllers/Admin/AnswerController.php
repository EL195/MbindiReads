<?php

namespace App\Http\Controllers\Admin;

use App\Models\Quiz;
use App\Models\Answer;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyFolderRequest;
use App\Http\Requests\StoreFolderRequest;
use App\Http\Requests\UpdateFolderRequest;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class AnswerController extends Controller
{
    use MediaUploadingTrait;
    

    

    public function index(Request $request)
    {
        $ressource_id = $request->quiz;
        $answers = Answer::query()->with("quiz")->get();
        $quiz = Quiz::query()->find($ressource_id);
    //dd($quizs);
        return view('admin.answers.index', compact('quiz', 'ressource_id' ,'answers'));
    }

    public function create(Request $request)
    {
        //$agegroups = Agegroup::all();
        $ressource_id = $request->quiz;
        //dd($ressource_id);
        return view('admin.answers.create', compact('ressource_id'));
    }

    public function store(StoreFolderRequest $request)
    {
        
        $request->validate([
            'file' => 'required|mimes:png,jpg,jpeg,gif|max:2048',
            ]);

            $fileModel = new Answer;

        if($request->file()) {
            $fileName = time().'_'.$request->file->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');
            $fileModel->image = '/storage/' . $filePath;
            $fileModel->choose = $request->choose;
            $fileModel->type = $request->type;
            $fileModel->quiz_id = $request->quiz_id;
            $fileModel->save();
        }
        else{
            $fileModel->choose = $request->choose;
            $fileModel->type = $request->type;
            $fileModel->title = $request->title;
            $fileModel->quiz_id = $request->quiz_id;
            $fileModel->save();

        }
        //$answer = Answer::create($request->all());
        return redirect()->route('admin.answers.index', ['quiz' => $request->quiz_id]);
    }

    public function edit($id)
    {

    
        return view('admin.answers.edit', [
            'answer' => Answer::query()->find($id),
        ]);
    }

    public function update(UpdateFolderRequest $request, $id)
    {
        $request->validate([
            'file' => 'required|mimes:png,jpg,jpeg,gif|max:2048',
            ]);

            $fileModel  = Answer::query()->find($id);

        if($request->file()) {
            $fileName = time().'_'.$request->file->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');
            $fileModel->image = '/storage/' . $filePath;
            $fileModel->choose = $request->choose;
            $fileModel->type = $request->type;
            $fileModel->quiz_id = $request->quiz_id;
            $fileModel->upadate();
        }
        else{
            $fileModel->choose = $request->choose;
            $fileModel->type = $request->type;
            $fileModel->title = $request->title;
            $fileModel->quiz_id = $request->quiz_id;
            $fileModel->upadate();

        }
        return redirect()->route('admin.answers.index', ['quiz' => $fileModel->quiz_id]);
    }


    public function destroy($id)
    {
        //dd($id);
        $asnswer=Answer::query()->find($id);
        $asnswer->delete();
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
