<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function getDetails()
    {
        $admin = \Auth::guard('admin')->user();
        return view('admin.profile', compact('admin'));
    }

    public function postUpdate(Request $request)
    {
        $admin = \Auth::guard('admin')->user();

        $this->validate($request, [
            'name' => 'required',
            'email' => "required|email|unique:admins,id,{$admin->id}",
            'mobile' => 'required|numeric|digits_between:9,20',
            'profile_image' => config('cms.allowed_image_mimes'),
        ]);
        $dataArr = arrayFromPost($request, ['name', 'email', 'mobile']);

        try {

            $admin->name = $dataArr->name;
            $admin->email = strtolower($dataArr->email);
            $admin->mobile = $dataArr->mobile;
            if (\Input::hasFile('profile_image')) {
                $admin->profile_image = uploadFile('profile_image');
            }
            $admin->save();
            return successMessage();

        } catch (\Exception $e) {
            return errorMessage($e->getMessage(), true);
        }
    }

    public function postChangePassword(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required|min:6',
            'password' => 'required|confirmed|min:6',
        ]);

        $fieldArr = ['old_password', 'password', 'locale'];
        $dataArr = arrayFromPost($request, $fieldArr);
        $admin = \Auth::guard('admin')->user();

        if (!\Hash::check($dataArr->old_password, $admin->password)) {
            return errorMessage('invalid_old_password');
        }
        $admin->password = bcrypt($dataArr->password);
        $admin->save();

        return successMessage('password_changed');
    }

    public function getLogout()
    {
        \Auth::guard('admin')->logout();
        return redirect()->route('admin.login')->with(['success' => transLang('user_logged_out')]);
    }
}
