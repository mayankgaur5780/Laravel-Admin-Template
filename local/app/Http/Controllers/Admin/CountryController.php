<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\WebController;
use Illuminate\Http\Request;

class CountryController extends WebController
{
    public function getIndex()
    {
        return view('admin.countries.index');
    }

    public function getList()
    {
        $list = \App\Models\Country::select(\DB::raw("countries.*, {$this->locale}name AS name"));

        return \DataTables::of($list)
            ->addColumn('status_text', function ($query) {
                return transLang('action_status')[$query->status];
            })
            ->make();
    }

    public function getCreate()
    {
        return view('admin.countries.create');
    }

    public function postCreate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'en_name' => 'required|unique:countries',
            'dial_code' => 'required',
            'alpha_2' => 'required|unique:countries',
            'alpha_3' => 'required|unique:countries',
            'currency' => 'required',
            'tax' => 'required|numeric|min:0',
            'status' => 'required',
            'file' => 'required|' . config('cms.allowed_image_mimes'),
        ]);
        $dataArr = arrayFromPost(['name', 'en_name', 'dial_code', 'alpha_2', 'alpha_3', 'currency', 'tax', 'status']);

        $country = new \App\Models\Country();
        $country->name = $dataArr->name;
        $country->en_name = $dataArr->en_name;
        $country->dial_code = $dataArr->dial_code;
        $country->alpha_2 = strtoupper($dataArr->alpha_2);
        $country->alpha_3 = strtoupper($dataArr->alpha_3);
        $country->currency = strtoupper($dataArr->currency);
        $country->tax = $dataArr->tax;
        $country->status = $dataArr->status;
        $country->flag = uploadFile('file', 'image', 'flagPath');
        $country->save();

        return successMessage();
    }

    public function getUpdate($id = null)
    {
        $country = \App\Models\Country::findOrFail($id);
        return view('admin.countries.update', compact('country'));
    }

    public function postUpdate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'en_name' => "required|unique:countries,en_name,{$request->id},id",
            'dial_code' => 'required',
            'status' => 'required',
            'file' => config('cms.allowed_image_mimes'),
        ]);
        $dataArr = arrayFromPost(['name', 'en_name', 'dial_code', 'status']);

        $country = \App\Models\Country::find($request->id);
        if ($country != null) {
            $country->name = $dataArr->name;
            $country->en_name = $dataArr->en_name;
            $country->dial_code = $dataArr->dial_code;
            $country->status = $dataArr->status;
            if (\Input::hasFile('file')) {
                $country->flag = uploadFile('file', 'image', 'flagPath');
            }
            $country->save();
        }

        return successMessage();
    }

    public function getDelete(Request $request)
    {
        \App\Models\Country::find($request->id)->delete();
        return successMessage();
    }
}
