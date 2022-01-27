<?php

namespace App\Http\Controllers\Admin;

use App\Models\Student;
use App\Models\Payement;
use App\Models\Notification;
use App\Models\Classe;
use App\Models\Langue;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyFolderRequest;
use App\Http\Requests\StoreFolderRequest;
use App\Http\Requests\UpdateFolderRequest;
use Gate;
use App\Models\Membership;
use App\Models\Agegroup;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Hash;

class PayController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        $memberships = Membership::all();
        $userId = Auth::id();
        $CurentUser= User::query()->where("id", $userId)->with("roles")->get()[0];
        if($CurentUser->roles[0]->title == "School"){
            $classes = Classe::query()->where("user_id", $userId)->get();
            return view('admin.pay.index', compact('memberships', 'classes'));
        }
        else{

        }

    }

    public function create()
    {
        $userId = Auth::id();
        $CurentUser= User::query()->where("id", $userId)->with("roles")->get()[0];
        $memberships = Membership::query()->where("type", strtolower($CurentUser->roles[0]->title))->get();
        if($CurentUser->roles[0]->title =="School"){
            $classes = Classe::query()->where("user_id", $userId)->get();
            $array[] = "";
            $array1[] = "";
            foreach ($classes as $classe) {
                $paid = Payement::query()->where("receiver", $classe->id)->where("start", 1)->where("status", '1')->with("membership")->get();
                if($paid->isEmpty()){
                    array_push($array, $classe);
                }
                else{
                    array_push($array1, $classe);
                }
            }
           // dd($array);
            $paidclasses = $array1;
            $role = $CurentUser->roles[0]->title;
            $classes = $array;
            return view('admin.pay.create', compact('memberships', 'classes', 'role', 'paidclasses'));
        }
        else{
            $array[] = "";
            $array1[] = "";
            $students = Student::query()->where("user_id", $userId)->get();
            foreach ($students as $student) {
                $paid = Payement::query()->where("receiver", $student->id)->where("start", 1)->where("status", '1')->with("membership")->get();
                if($paid->isEmpty()){
                    array_push($array, $student);
                }
                else{
                    array_push($array1, $student);
                }
            }
            $students = $array;
            $studentspaid = $array1;
            $role = $CurentUser->roles[0]->title;
            return view('admin.pay.create', compact('memberships', 'students', 'role', 'studentspaid'));

        }
    }

    public function store(StoreFolderRequest $request)
    {
        $membership=Membership::query()->find($request->membership);
        $userId = Auth::id();
        $CurentUser= User::query()->where("id", $userId)->with("roles")->get()[0];
        
        if($request->payement == "offline"){
            if($CurentUser->roles[0]->title == "School"){
                $pay = new Payement;
                $pay->membership_id = $request->membership;
                $pay->user_id = $userId;
                $pay->status = 0;
                $pay->start = 0;
                $pay->receiver = $request->classe;
                $pay->price = $membership->price;
                $pay->save();

                $notice = new Notification;
                $notice->users = $userId;
                $notice->receiver = $userId;
                $notice->title = $membership->name;
                $notice->type = "School";
                $notice->content = "";
                $notice->status = 0;
                $notice->save();

                return redirect()->route('admin.payement.index');
            }
            else{
                $pay = new Payement;
                $pay->membership_id = $request->membership;
                $pay->user_id = $userId;
                $pay->status = 0;
                $pay->start = 0;
                $pay->receiver = $request->student;
                $pay->price = $membership->price;
                $pay->save();

                $notice = new Notification;
                $notice->users = $userId;
                $notice->receiver = $userId;
                $notice->title = $membership->name;
                $notice->type = "Parent";
                $notice->content = "";
                $notice->status = 0;
                
                $notice->save();
                return redirect()->route('admin.payement.index');
            }
        }
        else{
            if($CurentUser->roles[0]->title == "School"){
                $pay = new Payement;
                $pay->membership_id = $request->membership;
                $pay->user_id = $userId;
                $pay->start = 1;
                $pay->start = 0;
                $pay->status = "complete";
                $pay->price = $membership->price;
                $pay->save();
                return redirect()->route('admin.payement.index');
            }
            else{
    
                return redirect()->route('admin.payement.index');
            }

        }
        
    }

    public function edit($id)
    {
        return view('admin.students.edit', [
            'langue' => Student::query()
                ->find($id),
        ]);
    }

    public function update(UpdateFolderRequest $request, $id)
    {
        $langue = Student::query()->find($id);
        $langue->title = $request->title;
        $langue->code = $request->code;
        $langue->status = $request->status;
        $langue->update();
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
