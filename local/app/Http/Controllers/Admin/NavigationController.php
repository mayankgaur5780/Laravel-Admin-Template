<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\WebController;
use Illuminate\Http\Request;

class NavigationController extends WebController
{

    public function getIndex(Request $request)
    {
        return view('admin.navigation.index');
    }

    public function getList(Request $request)
    {
        $list = \App\Models\AdminNavigation::select(\DB::raw("admin_navigations.*, {$this->locale}name AS name"));

        return \DataTables::of($list)
            ->addColumn('status_text', function ($query) {
                return transLang('action_status')[$query->status];
            })
            ->addColumn('show_in_menu_text', function ($query) {
                return transLang('other_action')[$query->show_in_menu];
            })
            ->addColumn('show_in_permission_text', function ($query) {
                return transLang('other_action')[$query->show_in_permission];
            })
            ->make();
    }

    public function getCreate(Request $request)
    {
        $locale = getCustomSessionLang();
        $parent_navigation = \App\Models\AdminNavigation::select(\DB::raw("id, {$locale}name AS name"))
            ->where('show_in_menu', 1)
            ->orderBy("{$locale}name")
            ->get();
        return view('admin.navigation.create', compact('parent_navigation'));
    }

    public function postCreate(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'en_name' => 'required',
            'action_path' => 'required',
            'display_order' => 'required|numeric',
            'parent_id' => 'nullable|numeric',
            'status' => 'required',
            'show_in_menu' => 'required',
            'show_in_permission' => 'required',
        ]);
        $dataArr = arrayFromPost(['name', 'en_name', 'action_path', 'icon', 'display_order', 'parent_id', 'status', 'show_in_menu', 'show_in_permission']);

        try {
            // Start Transaction
            \DB::beginTransaction();

            $navigationMaster = new \App\Models\AdminNavigation();
            $navigationMaster->name = $dataArr->name;
            $navigationMaster->en_name = $dataArr->en_name;
            $navigationMaster->action_path = $dataArr->action_path;
            $navigationMaster->icon = $dataArr->icon;
            $navigationMaster->display_order = $dataArr->display_order;
            $navigationMaster->parent_id = $dataArr->parent_id;
            $navigationMaster->status = $dataArr->status;
            $navigationMaster->show_in_menu = $dataArr->show_in_menu;
            $navigationMaster->show_in_permission = $dataArr->show_in_permission;
            $navigationMaster->save();

            // Update Navigation
            navigationMenuListing();

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
        $locale = getCustomSessionLang();
        $navigation = \App\Models\AdminNavigation::findOrFail($request->id);
        $parent_navigation = \App\Models\AdminNavigation::select(\DB::raw("id, {$locale}name AS name"))
            ->where('show_in_menu', 1)
            ->orderBy("{$locale}name")
            ->get();
        return view('admin.navigation.update', compact('navigation', 'parent_navigation'));
    }

    public function postUpdate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'en_name' => 'required',
            'action_path' => 'required',
            'display_order' => 'required|numeric',
            'parent_id' => 'nullable|numeric',
            'status' => 'required',
            'show_in_menu' => 'required',
            'show_in_permission' => 'required',
        ]);
        $dataArr = arrayFromPost(['name', 'en_name', 'action_path', 'icon', 'display_order', 'parent_id', 'status', 'show_in_menu', 'show_in_permission']);

        try {
            // Start Transaction
            \DB::beginTransaction();

            $navigationMaster = \App\Models\AdminNavigation::find($request->id);
            if (!blank($navigationMaster)) {
                $navigationMaster->name = $dataArr->name;
                $navigationMaster->en_name = $dataArr->en_name;
                $navigationMaster->action_path = $dataArr->action_path;
                $navigationMaster->icon = $dataArr->icon;
                $navigationMaster->display_order = $dataArr->display_order;
                $navigationMaster->parent_id = $dataArr->parent_id;
                $navigationMaster->status = $dataArr->status;
                $navigationMaster->show_in_menu = $dataArr->show_in_menu;
                $navigationMaster->show_in_permission = $dataArr->show_in_permission;
                $navigationMaster->save();
            }

            // Update Navigation
            navigationMenuListing();

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
