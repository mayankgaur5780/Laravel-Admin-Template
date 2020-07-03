<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubAdminController extends Controller
{
    public function getIndex(Request $request)
    {
        abort_unless(hasPermission('admin/sub_admins'), 401);

        return view('admin.sub_admins.index');
    }

    public function getList(Request $request)
    {
        $list = \App\Models\Admin::select(\DB::raw('admins.*, admin_roles.name AS role'))
            ->leftJoin('admin_roles', 'admin_roles.id', '=', 'admins.admin_role_id')
            ->where('admins.id', '<>', 1);

        return \DataTables::of($list)
            ->addColumn('status_text', function ($query) {
                return transLang('action_status')[$query->status];
            })
            ->make();
    }

    public function getCreate(Request $request)
    {
        abort_unless(hasPermission('create_sub_admin'), 401);

        $locale = getCustomSessionLang();

        $dial_codes = \App\Models\Country::select(\DB::raw("dial_code, CONCAT(dial_code, ' (', {$locale}name,')') AS name"))
            ->where('status', 1)
            ->orderBy('dial_code')
            ->get();

        $roles = \App\Models\AdminRole::where('status', 1)
            ->where('id', '<>', 1)
            ->orderBy('name')
            ->get();
        return view('admin.sub_admins.create', compact('roles', 'dial_codes'));
    }

    public function postCreate(Request $request)
    {
        $this->validate($request, [
            'role_id' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:admins,email',
            'dial_code' => 'required|numeric|digits_between:1,5',
            'mobile' => 'required|numeric|digits_between:8,15',
            'password' => 'required|min:6',
            'profile_image' => config('cms.allowed_image_mimes'),
        ]);
        $dataArr = arrayFromPost(['name', 'email', 'dial_code', 'mobile', 'password', 'role_id', 'status']);

        try {
            // Start Transaction
            \DB::beginTransaction();

            $admin = new \App\Models\Admin();
            $admin->name = $dataArr->name;
            $admin->email = strtolower($dataArr->email);
            $admin->dial_code = $dataArr->dial_code;
            $admin->mobile = ltrim($dataArr->mobile, '0');
            $admin->password = bcrypt($dataArr->password);
            $admin->admin_role_id = $dataArr->role_id;
            $admin->hash_token = generateRandomString(30);
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
        abort_unless(hasPermission('update_sub_admin'), 401);

        $locale = getCustomSessionLang();
        $admin = \App\Models\Admin::findOrFail($request->id);

        $dial_codes = \App\Models\Country::select(\DB::raw("dial_code, CONCAT(dial_code, ' (', {$locale}name,')') AS name"))
            ->where('status', 1)
            ->orWhere('dial_code', $admin->dial_code)
            ->orderBy('dial_code')
            ->get();

        $roles = \App\Models\AdminRole::where(function ($query) {
            $query->where('status', 1)
                ->where('id', '<>', 1);
        })
            ->orWhere('id', $admin->admin_role_id)
            ->orderBy('name')
            ->get();
        return view('admin.sub_admins.update', compact('admin', 'roles', 'dial_codes'));
    }

    public function postUpdate(Request $request)
    {
        $this->validate($request, [
            'role_id' => 'required',
            'name' => 'required',
            'email' => "required|email|unique:admins,email,{$request->id}",
            'dial_code' => 'required|numeric|digits_between:1,5',
            'mobile' => 'required|numeric|digits_between:8,15',
            'profile_image' => config('cms.allowed_image_mimes'),
        ]);
        $dataArr = arrayFromPost(['name', 'email', 'dial_code', 'mobile', 'role_id', 'status']);

        try {
            // Start Transaction
            \DB::beginTransaction();

            $admin = \App\Models\Admin::find($request->id);
            $admin->name = $dataArr->name;
            $admin->email = strtolower($dataArr->email);
            $admin->dial_code = $dataArr->dial_code;
            $admin->mobile = ltrim($dataArr->mobile, '0');
            $admin->admin_role_id = $dataArr->role_id;
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
        abort_unless(hasPermission('delete_sub_admin'), 401);

        \App\Models\Admin::find($request->id)->delete();
        return successMessage();
    }

    public function getView(Request $request)
    {
        abort_unless(hasPermission('admin/sub_admins'), 401);

        $admin = \App\Models\Admin::findOrFail($request->id);
        $admin->role = \App\Models\AdminRole::where('id', $admin->admin_role_id)->value('name');
        return view('admin.sub_admins.view', compact('admin'));
    }

    public function getPasswordReset(Request $request)
    {
        abort_unless(hasPermission('change_password_sub_admin'), 401);

        $admin = \App\Models\Admin::findOrFail($request->id);
        return view('admin.sub_admins.password-reset', compact('admin'));
    }

    public function postPasswordReset(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|min:6|confirmed',
        ]);
        $dataArr = arrayFromPost(['password']);

        try {
            // Start Transaction
            \DB::beginTransaction();

            $admin = \App\Models\Admin::find($request->id);
            $admin->password = bcrypt($dataArr->password);
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
}
