<?php

namespace App\Http\Controllers\Admin;

use App\Models\Student;
use App\Models\Setting;
use App\Models\Classe;
use App\Models\Score;
use App\Models\Langue;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyFolderRequest;
use App\Http\Requests\StoreFolderRequest;
use App\Http\Requests\UpdateFolderRequest;
use Gate;
use App\Models\Agegroup;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
       $userId = Auth::id();
       $settings = Setting::query()->where("meta", "class_limit")->get()[0];
       //$count = Classe::query()->where("user_id", $userId)->count();
       //dd($settings->value);
       $CurentUser= User::query()->where("id", $userId)->with("roles")->get()[0];
       if($CurentUser->roles[0]->title == "School"){
        $class_id = $request->class;
        $students = Student::query()->where("classe_id", $class_id)->get();
        $count = Student::query()->where("classe_id", $class_id)->count();
        $classe = Classe::query()->find($class_id);
        $role = $CurentUser->roles[0]->title;
        $remain = $settings->value - $count;
        return view('admin.students.index', compact('role', 'students', 'count', 'classe', 'settings', 'remain'));

       }
       else{
        $students = Student::query()->where("user_id", $userId)->get();
        //dd($students);
        $count = Student::query()->where("user_id", $userId)->count();
        $role = $CurentUser->roles[0]->title;
        return view('admin.students.index', compact('role', 'students', 'count', 'settings'));
       }
       
    }

    public function create(Request $request)
    {
        $class_id = $request->class;
        $ages = Agegroup::all();
        $langues = Langue::all();
        return view('admin.students.create', compact('langues', 'ages', 'class_id'));
    }

    

    public function store(StoreFolderRequest $request)
    {

        //$this->validate($this->rules());

        $request->validate([
        'username' => 'required|unique:students',
            //'image' => 'required|mimes:png,jpg,jpeg,gif|max:2048'
        ]);


        $userId = Auth::id();
        $CurentUser= User::query()->where("id", $userId)->with("roles")->get()[0];
        if($CurentUser->roles[0]->title == "School"){
            $student = new Student;
            $student->last_name = $request->last_name;
            $student->first_name  = $request->first_name;
            $student->username = $request->username;
            $student->age = $request->age;
            $student->langue_id = $request->langue;
            $student->password = $request->password;
            $student->classe_id = $request->classe_id;
            $student->save();

            $score = new Score;
            $score->points = 0;
            $score->student_id = $student->id;
            $score->save();

            return redirect()->route('admin.students.index', ['class' => $request->classe_id]);
        }
        else{
            $student = new Student;
            $student->last_name = $request->last_name;
            $student->first_name  = $request->first_name;
            $student->username = $request->username;
            $student->age = $request->age;
            $student->langue_id = $request->langue;
            $student->password = $request->password;
            $student->user_id = $userId;
            $student->save();

            $score = new Score;
            $score->points = 0;
            $score->student_id = $student->id;
            $score->save();

            return redirect()->route('admin.students.index');
        }
        
    }

    public function edit($id)
    {
        $ages = Agegroup::all();
        $student = Student::query()->find($id);
        return view('admin.students.edit', compact('ages', 'student'));
    }

    public function update(UpdateFolderRequest $request, $id)
    {
        $student = Student::query()->find($id);
        $student->last_name = $request->last_name;
        $student->first_name  = $request->first_name;
        $student->username = $request->username;
        $student->age = $request->age;
        $student->password = $request->password;
        $student->update();
        return redirect()->route('admin.students.index');
    }


    public function destroy($id)
    {
        //dd($id);
        $langue= Student::query()->find($id);
        $langue->delete();
        return back();
    }

    public function massDestroy(MassDestroyFolderRequest $request)
    {
        Student::whereIn('id', request('ids'))->delete();

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
