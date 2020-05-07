<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\WebController;
use Illuminate\Http\Request;

class SettingController extends WebController
{
    public function getIndex()
    {
        return view('admin.settings.index');
    }

    public function getList()
    {
        $settings = \App\Models\Setting::select(['*']);
        return \DataTables::of($settings)->make();
    }

    public function getUpdate(Request $request)
    {
        $setting = \App\Models\Setting::findOrFail($request->id);
        return view('admin.settings.update', compact('setting'));
    }

    public function postUpdate(Request $request)
    {
        $this->validate($request, [
            'label' => 'required',
            'value' => 'required',
        ]);

        $settings = \App\Models\Setting::find($request->id);
        $settings->label = $request->label;
        $settings->value = $request->value;
        $settings->save();

        return successMessage();
    }
}
