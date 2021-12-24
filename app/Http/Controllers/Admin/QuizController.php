<?php

namespace App\Http\Controllers\Admin;

use App\Models\Quiz;
use App\Models\Ressource;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyFolderRequest;
use App\Http\Requests\StoreFolderRequest;
use App\Http\Requests\UpdateFolderRequest;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class QuizController extends Controller
{
    use MediaUploadingTrait;
    

    

    public function index(Request $request)
    {
        $ressource_id = $request->quiz;
        $quizs = Quiz::query()->with("ressource")->get();
        $ressource = Ressource::query()->find($ressource_id);
    //dd($quizs);
        return view('admin.quiz.index', compact('quizs', 'ressource_id' ,'ressource'));
    }

    public function create(Request $request)
    {
        //$agegroups = Agegroup::all();
        $ressource_id = $request->quiz;
        //dd($ressource_id);
        return view('admin.quiz.create', compact('ressource_id'));
    }

    public function store(StoreFolderRequest $request)
    {
        //dd($request);
        $quiz = Quiz::create($request->all());
        return redirect()->route('admin.quiz.index', ['quiz' => $request->ressource_id]);


    }

    public function edit($id)
    {

    
        return view('admin.quiz.edit', [
            'quiz' => Quiz::query()->find($id),
        ]);
    }

    public function update(UpdateFolderRequest $request, $id)
    {
        $quiz = Quiz::query()->find($id);
        $quiz->title = $request->title;
        $quiz->points = $request->points;
        $quiz->total_questions = $request->total_questions;
        $quiz->update();
        return redirect()->route('admin.quiz.index' ,['quiz' => $quiz->ressource_id]);
    }


    public function destroy($id)
    {
        //dd($id);
        $quiz=Quiz::query()->find($id);
        $quiz->delete();
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
