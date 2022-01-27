<?php

namespace App\Http\Controllers\Admin;

use App\Models\Payement;
use App\User;
use App\Memberships;
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

class PayementController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {

        $userId = Auth::id();
        $CurentUser= User::query()->where("id", $userId)->with("roles")->get()[0];

        if($CurentUser->roles[0]->title == "Admin"){
       // $userId = Auth::id();
        $payements = Payement::query()->with("user", "membership")->get();
        $CurentUser= User::query()->with("roles")->get()[0];
        $role = $CurentUser->roles[0]->title;
        //dd($payements);
        return view('admin.payement.index', compact('payements', 'role'));
        }
        else{
            if($CurentUser->roles[0]->title == "Parent"){
                $payements = Payement::query()->where("user_id", $userId)->with("user", "membership", "student")->get();
                //dd($payements);
                $role = $CurentUser->roles[0]->title;
                return view('admin.payement.index', compact('payements', 'role'));
            }
            else{
                $payements = Payement::query()->where("user_id", $userId)->with("user", "membership", "classe")->get();
                //dd($payements);
                $role = $CurentUser->roles[0]->title;
                return view('admin.payement.index', compact('payements', 'role')); 
            }

        }
    }

    public function create()
    {
        $agegroups = Agegroup::all();
        return view('admin.levels.create', compact('agegroups'));
    }

    public function store(StoreFolderRequest $request)
    {
        $level = Level::create($request->all());
        return redirect()->route('admin.levels.index');


    }

    public function edit($id)
    {

       // $agegroups = Agegroup::all();
        return view('admin.levels.edit', [
            'level' => Level::query()->find($id),
            'agegroups' => Agegroup::all(),
        ]);
    }

    public function update(UpdateFolderRequest $request, $id)
    {
        $level = Level::query()->find($id);
        $level->name = $request->name;
        $level->description = $request->description;
        $level->order = $request->order;
        $level->agegroup_id = $request->agegroup_id;
        $level->update();
        return redirect()->route('admin.levels.index');
    }


    public function destroy($id)
    {
        //dd($id);
        $payement=Payement::query()->find($id);
        $payement->status = 1;
        $payement->start = 1;
        $payement->update();
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
