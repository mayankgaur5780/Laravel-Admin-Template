<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\WebController;
use Illuminate\Http\Request;

class FaqController extends WebController
{
    public function getIndex(Request $request)
    {
        abort_unless(hasPermission('admin/faq'), 401);

        return view('admin.faq.index');
    }

    public function getList(Request $request)
    {
        $list = \App\Models\Faq::select(\DB::raw("faq.*, faq.{$this->locale}title as title"));
        return \DataTables::of($list)->make();
    }

    public function getCreate(Request $request)
    {
        abort_unless(hasPermission('create_faq'), 401);

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

        try {
            $faq = new \App\Models\Faq();
            $faq->title = $dataArr->title;
            $faq->en_title = $dataArr->en_title;
            $faq->content = $dataArr->content;
            $faq->en_content = $dataArr->en_content;
            $faq->save();

            return successMessage();
        } catch (\Throwable $th) {
            return exceptionErrorMessage($th);
        }
    }

    public function getUpdate(Request $request)
    {
        abort_unless(hasPermission('update_faq'), 401);

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

        try {
            $faq = \App\Models\Faq::find($request->id);
            if (!blank($faq)) {
                $faq->title = $dataArr->title;
                $faq->en_title = $dataArr->en_title;
                $faq->content = $dataArr->content;
                $faq->en_content = $dataArr->en_content;
                $faq->save();
            }

            return successMessage();
        } catch (\Throwable $th) {
            return exceptionErrorMessage($th);
        }
    }

    public function getDelete(Request $request)
    {
        abort_unless(hasPermission('delete_faq'), 401);

        \App\Models\Faq::find($request->id)->delete();
        return successMessage();
    }
}
