<?php

namespace App\Http\Controllers\Admin;

use App\Models\Membership;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyFolderRequest;
use App\Http\Requests\StoreFolderRequest;
use App\Http\Requests\UpdateFolderRequest;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class MembershipController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {

        $memberships = Membership::all();
        return view('admin.memberships.index', compact('memberships'));
    }

    public function create()
    {
        return view('admin.memberships.create');
    }

    public function store(StoreFolderRequest $request)
    {
        $membership = Membership::create($request->all());
        return redirect()->route('admin.memberships.index');
    }

    public function edit($id)
    {
        return view('admin.memberships.edit', [
            'membership' => Membership::query()
                ->find($id),
        ]);
    }

    public function update(UpdateFolderRequest $request, $id)
    {
        $membership = Membership::query()->find($id);
        $membership->name = $request->name;
        $membership->price = $request->price;
        $membership->type = $request->type;
        $membership->periode = $request->periode;
        $membership->description = $request->description;
        $membership->update();
        return redirect()->route('admin.memberships.index');
    }


    public function destroy($id)
    {
        //dd($id);
        $membership=Membership::query()->find($id);
        $membership->delete();
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
