<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\WebController;
use Illuminate\Http\Request;

class AdminController extends WebController
{
    public function getIndex()
    {
        return view('admin.admins.index');
    }

    public function getList()
    {
        $list = \App\Models\Admin::select(['id', 'name', 'email', 'mobile', 'status', 'created_at'])
            ->where('id', '!=', 1);

        return \DataTables::of($list)
            ->addColumn('status_text', function ($query) {
                return transLang('action_status')[$query->status];
            })
            ->make();
    }

    public function getCreate()
    {
        $roles = \App\Models\AdminRole::where('status', '=', 1)
            ->where('id', '<>', [1])
            ->get();
        return view('admin.admins.create', compact('roles'));
    }

    public function postCreate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:admins,email',
            'mobile' => 'nullable|numeric|min:9',
            'password' => 'required|min:6',
            'user_type' => 'required',
            'profile_image' => config('cms.allowed_image_mimes'),
        ]);
        $dataArr = arrayFromPost(['name', 'email', 'user_type', 'mobile', 'password', 'status']);

        try {
            // Start Transaction
            \DB::beginTransaction();

            $admin = new \App\Models\Admin();
            $admin->name = $dataArr->name;
            $admin->role_id = $dataArr->user_type;
            $admin->email = $dataArr->email;
            $admin->password = bcrypt($dataArr->password);
            $admin->mobile = $dataArr->mobile;
            $admin->status = $dataArr->status;
            if (\Input::hasFile('profile_image')) {
                $admin->profile_image = uploadFile('profile_image');
            }
            $admin->save();

            // Commit Transaction
            \DB::commit();
            return successMessage();

        } catch (\Exception $e) {
            // Rollback Transaction
            \DB::rollBack();
            return errorMessage($e->getMessage(), true);
        }
    }

    public function getUpdate(Request $request)
    {
        $admin = \App\Models\Admin::findOrFail($request->id);
        $roles = \App\Models\AdminRole::whereIn('id', [1, 2])->get();
        return view('admin.admins.update', compact('admin', 'roles'));
    }

    public function postUpdate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => "required|email|unique:admins,email,{$request->id}",
            'user_type' => 'required',
            'mobile' => 'nullable|numeric|min:9',
            'profile_image' => config('cms.allowed_image_mimes'),
        ]);
        $dataArr = arrayFromPost(['name', 'email', 'user_type', 'mobile', 'locale', 'status']);

        try {
            // Start Transaction
            \DB::beginTransaction();

            $admin = \App\Models\Admin::find($request->id);
            $admin->name = $dataArr->name;
            $admin->email = $dataArr->email;
            $admin->mobile = $dataArr->mobile;
            $admin->role_id = $dataArr->user_type;
            $admin->status = $dataArr->status;
            if (\Input::hasFile('profile_image')) {
                $admin->profile_image = uploadFile('profile_image');
            }
            $admin->save();

            // Commit Transaction
            \DB::commit();
            return successMessage();

        } catch (\Exception $e) {
            // Rollback Transaction
            \DB::rollBack();
            return errorMessage($e->getMessage(), true);
        }
    }

    public function getDelete(Request $request)
    {
        \App\Models\Admin::find($request->id)->delete();
        return successMessage();
    }

    public function getView(Request $request)
    {
        $admin = \App\Models\Admin::findOrFail($request->id);
        $admin->role = \App\Models\AdminRole::find($admin->role_id);
        return view('admin.admins.view', compact('admin'));
    }

    public function getPasswordReset(Request $request)
    {
        $admin = \App\Models\Admin::findOrFail($request->id);
        return view('admin.admins.password-reset', compact('admin'));
    }

    public function postPasswordReset(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|min:6|confirmed',
        ]);

        $admin = \App\Models\Admin::find($request->id);
        $admin->password = bcrypt($request->password);
        $admin->save();

        return successMessage('password_changed_successfully');
    }
}
