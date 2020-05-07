<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\WebController;
use Illuminate\Http\Request;

class FaqController extends WebController
{
    public function getIndex()
    {
        return view('admin.faq.index');
    }

    public function getList()
    {
        $list = \App\Models\Faq::select('*');
        return \DataTables::of($list)->make();
    }

    public function getCreate()
    {
        return view('admin.faq.create');
    }

    public function postCreate(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'en_title' => 'required',
            'content' => 'required',
            'en_content' => 'required',
        ]);
        $dataArr = arrayFromPost(['title', 'en_title', 'content', 'en_content']);

        $faq = new \App\Models\Faq();
        $faq->title = $dataArr->title;
        $faq->en_title = $dataArr->en_title;
        $faq->content = $dataArr->content;
        $faq->en_content = $dataArr->en_content;
        $faq->save();

        return successMessage();
    }

    public function getUpdate(Request $request)
    {
        $faq = \App\Models\Faq::findOrFail($request->id);
        return view('admin.faq.update', compact('faq'));
    }

    public function postUpdate(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'en_title' => 'required',
            'content' => 'required',
            'en_content' => 'required',
        ]);
        $dataArr = arrayFromPost(['title', 'en_title', 'content', 'en_content']);

        $faq = \App\Models\Faq::find($request->id);
        if ($faq != null) {
            $faq->title = $dataArr->title;
            $faq->en_title = $dataArr->en_title;
            $faq->content = $dataArr->content;
            $faq->en_content = $dataArr->en_content;
            $faq->save();
        }

        return successMessage();
    }

    public function getDelete(Request $request)
    {
        \App\Models\Faq::find($request->id)->delete();
        return successMessage();
    }
}
