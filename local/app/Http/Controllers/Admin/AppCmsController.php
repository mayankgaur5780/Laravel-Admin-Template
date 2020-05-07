<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\WebController;
use Illuminate\Http\Request;

class AppCmsController extends WebController
{
    public function getIndex()
    {
        return view('admin.app_cms.index');
    }

    public function getList()
    {
        $list = \App\Models\AppCms::select('*');
        return \DataTables::of($list)->make();
    }

    public function getCreate()
    {
        return view('admin.app_cms.create');
    }

    public function postCreate(Request $request)
    {
        $this->validate($request, [
            'attribute' => 'required|unique:app_cms,attribute',
            'title' => 'required',
            'en_title' => 'required',
            'content' => 'required',
            'en_content' => 'required',
        ]);
        $dataArr = arrayFromPost(['attribute', 'title', 'en_title', 'content', 'en_content', 'status']);

        $app_cms = new \App\Models\AppCms();
        $app_cms->attribute = strtolower($dataArr->attribute);
        $app_cms->title = $dataArr->title;
        $app_cms->en_title = $dataArr->en_title;
        $app_cms->content = $dataArr->content;
        $app_cms->en_content = $dataArr->en_content;
        $app_cms->save();

        return successMessage();
    }

    public function getUpdate($id = null)
    {
        $app_cms = \App\Models\AppCms::findOrFail($id);
        return view('admin.app_cms.update', compact('app_cms'));
    }

    public function postUpdate(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'en_title' => 'required',
            'content' => 'required',
            'en_content' => 'required',
        ]);
        $dataArr = arrayFromPost(['title', 'en_title', 'content', 'en_content', 'status']);

        $app_cms = \App\Models\AppCms::find($request->id);
        if ($app_cms != null) {
            $app_cms->title = $dataArr->title;
            $app_cms->en_title = $dataArr->en_title;
            $app_cms->content = $dataArr->content;
            $app_cms->en_content = $dataArr->en_content;
            $app_cms->save();
        }

        return successMessage();
    }
}
