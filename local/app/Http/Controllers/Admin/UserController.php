<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\WebController;
use Illuminate\Http\Request;

class UserController extends WebController
{
    public function getIndex()
    {
        return view('admin.users.index');
    }

    public function getList()
    {
        $users = \App\Models\User::select('*');
        
        return \DataTables::of($users)
            ->addColumn('status_text', function ($query) {
                return transLang('action_status')[$query->status];
            })
            ->make();
    }

    public function getCreate()
    {
        $dial_codes = \App\Models\Country::select(\DB::raw("dial_code, CONCAT(dial_code, ' (', {$this->locale}name, ')') AS text"))
            ->where('status', 1)
            ->orderBy("{$this->locale}name")
            ->get();

        return view('admin.users.create', compact('dial_codes'));
    }

    public function postCreate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'dial_code' => 'required|numeric|digits_between:1,5',
            'mobile' => 'required|numeric|digits_between:9,20',
            'email' => 'nullable|email',
            'password' => 'required|min:6',
            'profile_image' => config('cms.allowed_image_mimes'),
        ]);
        $dataArr = arrayFromPost(['name', 'email', 'dial_code', 'mobile', 'password', 'status']);

        // Check Mobile No Duplicate
        if (\App\Models\User::where('dial_code', $dataArr->dial_code)->where('mobile', $dataArr->mobile)->count()) {
            return errorMessage('mobile_already_taken');
        }

        try {
            // Start Transaction
            \DB::beginTransaction();

            $user = new \App\Models\User();
            $user->name = $dataArr->name;
            $user->email = strtolower($dataArr->email);
            $user->password = bcrypt($request->password);
            $user->dial_code = $dataArr->dial_code;
            $user->mobile = $dataArr->mobile;
            $user->status = $dataArr->status;
            $user->profile_image = uploadFile('profile_image');
            $user->save();

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
        $user = \App\Models\User::findOrFail($request->id);
        $dial_codes = \App\Models\Country::select(\DB::raw("dial_code, CONCAT(dial_code, ' (', {$this->locale}name, ')') AS text"))
            ->orderBy("{$this->locale}name")
            ->get();

        return view('admin.users.update', compact('user', 'dial_codes'));
    }

    public function postUpdate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'nullable|email',
            'dial_code' => 'required|numeric|digits_between:1,5',
            'mobile' => 'required|numeric|digits_between:9,20',
            'profile_image' => config('cms.allowed_image_mimes'),
        ]);
        $dataArr = arrayFromPost(['name', 'email', 'dial_code', 'mobile', 'status']);

        // Check Mobile No Duplicate
        if (\App\Models\User::where('dial_code', $dataArr->dial_code)->where('mobile', $dataArr->mobile)->where('id', '<>', $request->id)->exists()) {
            return errorMessage('mobile_already_taken');
        }

        try {
            // Start Transaction
            \DB::beginTransaction();

            $user = \App\Models\User::find($request->id);
            $user->name = $dataArr->name;
            $user->email = strtolower($dataArr->email);
            $user->dial_code = $dataArr->dial_code;
            $user->mobile = $dataArr->mobile;
            $user->status = $dataArr->status;
            if (\Input::hasFile('profile_image')) {
                $user->profile_image = uploadFile('profile_image');
            }
            $user->save();

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
        $user = \App\Models\User::find($request->id)->delete();
        return successMessage();
    }

    public function getView(Request $request)
    {
        $user = \App\Models\User::findOrFail($request->id);
        return view('admin.users.view', compact('user'));
    }

    public function getPasswordReset(Request $request)
    {
        $user = \App\Models\User::findOrFail($request->id);
        return view('admin.users.password-reset', compact('user'));
    }

    public function postPasswordReset(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|min:6|confirmed',
        ]);

        $user = \App\Models\User::find($request->id);
        $user->password = bcrypt($request->password);
        $user->save();

        return successMessage('password_changed_successfully');
    }
}
