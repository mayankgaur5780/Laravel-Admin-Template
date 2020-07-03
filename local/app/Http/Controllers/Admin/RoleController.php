<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\WebController;
use Illuminate\Http\Request;

class RoleController extends WebController
{
    public function getIndex(Request $request)
    {
        return view('admin.role.index');
    }

    public function getList(Request $request)
    {
        $list = \App\Models\AdminRole::where('id', '<>', 1);

        return \DataTables::of($list)
            ->addColumn('status_text', function ($query) {
                return transLang('action_status')[$query->status];
            })
            ->make();
    }

    public function getCreate(Request $request)
    {
        return view('admin.role.create');
    }

    public function postCreate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:users_roles',
            'status' => 'required',
        ]);
        $dataArr = arrayFromPost(['name', 'en_name', 'status']);

        try {
            $role = new \App\Models\AdminRole();
            $role->name = $dataArr->name;
            $role->status = $dataArr->status;
            $role->save();

            return successMessage();
        } catch (\Exception $e) {
            return errorMessage($e->getMessage(), true);
        }
    }

    public function getUpdate(Request $request)
    {
        $role = \App\Models\AdminRole::findOrFail($request->id);
        return view('admin.role.update', compact('role'));
    }

    public function postUpdate(Request $request)
    {
        $this->validate($request, [
            'name' => "required|unique:users_roles,name,{$request->id}",
            'status' => 'required',
        ]);
        $dataArr = arrayFromPost(['name', 'en_name', 'status']);

        try {
            $role = \App\Models\AdminRole::find($request->id);
            if (!blank($role)) {
                $role->name = $dataArr->name;
                $role->status = $dataArr->status;
                $role->save();
            }

            return successMessage();
        } catch (\Exception $e) {
            return errorMessage($e->getMessage(), true);
        }
    }

    public function getPermission(Request $request)
    {
        $navigation = getGroupNavigation();
        $rolePermissions = getRolePermission($request->id);
        return view('admin.role.permission', compact('navigation', 'rolePermissions'));
    }

    public function savePermission(Request $request)
    {
        $this->validate($request, [
            'navigation_id' => 'required|array',
        ]);
        $dataArr = arrayFromPost(['navigation_id']);

        try {
            // Start Transaction
            \DB::beginTransaction();

            $result = \App\Models\RolePermission::where('role_id', '=', $request->id)->get();
            if ($result->isNotEmpty()) {
                foreach ($result as $value) {
                    $item = \App\Models\RolePermission::find($value->id);
                    $item->delete();
                }
            }
            if (count($dataArr->navigation_id)) {
                foreach ($dataArr->navigation_id as $navigation_id) {
                    $rolesPermissions = new \App\Models\RolePermission();
                    $rolesPermissions->role_id = $request->id;
                    $rolesPermissions->navigation_id = $navigation_id;
                    $rolesPermissions->save();
                }
            }

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
