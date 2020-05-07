<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\WebController;
use Illuminate\Http\Request;

class NavigationController extends WebController
{

    public function getIndex()
    {
        return view('admin.navigation.index');
    }

    public function getList()
    {
        $list = \App\Models\Navigation::select(\DB::raw("navigation.*, {$this->locale}name AS name"));

        return \DataTables::of($list)
            ->addColumn('status_text', function ($query) {
                return transLang('action_status')[$query->status];
            })
            ->addColumn('type_text', function ($query) {
                return transLang('navigation_types')[$query->type];
            })
            ->make();
    }

    public function getCreate()
    {
        $locale = getCustomSessionLang();
        $parent_navigation = \App\Models\Navigation::select(\DB::raw("id, {$locale}name AS name"))->where('parent_id', 0)->get();
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
            'type' => 'required',
        ]);
        $dataArr = arrayFromPost(['name', 'en_name', 'action_path', 'icon', 'display_order', 'parent_id', 'status', 'show_in_menu', 'show_in_permission', 'type']);

        $navigationMaster = new \App\Models\Navigation();
        $navigationMaster->name = $dataArr->name;
        $navigationMaster->en_name = $dataArr->en_name;
        $navigationMaster->action_path = $dataArr->action_path;
        $navigationMaster->icon = $dataArr->icon;
        $navigationMaster->display_order = $dataArr->display_order;
        $navigationMaster->parent_id = $dataArr->parent_id;
        $navigationMaster->status = $dataArr->status;
        $navigationMaster->show_in_menu = $dataArr->show_in_menu;
        $navigationMaster->show_in_permission = $dataArr->show_in_permission;
        $navigationMaster->type = $dataArr->type;
        $navigationMaster->save();

        // Update Navigation
        navigationMenuListing();

        return successMessage();
    }

    public function getUpdate(Request $request)
    {
        $locale = getCustomSessionLang();
        $navigation = \App\Models\Navigation::findOrFail($request->id);
        $parent_navigation = \App\Models\Navigation::select(\DB::raw("id, {$locale}name AS name"))->where('parent_id', 0)->get();
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
            'type' => 'required',
        ]);
        $dataArr = arrayFromPost(['name', 'en_name', 'action_path', 'icon', 'display_order', 'parent_id', 'status', 'show_in_menu', 'show_in_permission', 'type']);

        $navigationMaster = \App\Models\Navigation::find($request->id);
        if ($navigationMaster != null) {
            $navigationMaster->name = $dataArr->name;
            $navigationMaster->en_name = $dataArr->en_name;
            $navigationMaster->action_path = $dataArr->action_path;
            $navigationMaster->icon = $dataArr->icon;
            $navigationMaster->display_order = $dataArr->display_order;
            $navigationMaster->parent_id = $dataArr->parent_id;
            $navigationMaster->status = $dataArr->status;
            $navigationMaster->show_in_menu = $dataArr->show_in_menu;
            $navigationMaster->show_in_permission = $dataArr->show_in_permission;
            $navigationMaster->type = $dataArr->type;
            $navigationMaster->save();
        }

        // Update Navigation
        navigationMenuListing();

        return successMessage();
    }
}
