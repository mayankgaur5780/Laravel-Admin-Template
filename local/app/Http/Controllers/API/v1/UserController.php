<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function updateProfile(Request $request)
    {
        $user = getTokenUser($request);

        $this->validate($request, [
            'name' => 'required',
            'email' => 'nullable|email',
            'dial_code' => 'required|numeric|exists:countries,dial_code',
            'mobile' => 'required|numeric|digits_between:9,20',
            'address' => 'nullable',
            'gender' => 'nullable|numeric|in:1,2',
            'dob' => 'nullable|date_format:Y-m-d|before:today',
        ]);
        $dataArr = arrayFromPost($request, ['name', 'email', 'dial_code', 'mobile', 'address', 'gender', 'dob']);

        try {
            // Start Transaction
            \DB::beginTransaction();

            // Check Mobile No Duplicate
            $dataArr->mobile = ltrim($dataArr->mobile, '0');
            if (\App\Models\User::where('dial_code', $dataArr->dial_code)->where('mobile', $dataArr->mobile)->where('id', '<>', $user->id)->count()) {
                return errorMessage('mobile_already_taken');
            }

            $user->name = $dataArr->name;
            $user->dial_code = $dataArr->dial_code;
            $user->mobile = $dataArr->mobile;
            $user->email = strtolower($dataArr->email);
            $user->address = $dataArr->address;
            $user->gender = $dataArr->gender ? $dataArr->gender : null;
            $user->dob = $dataArr->dob ? date('Y-m-d', strtotime($dataArr->dob)) : null;
            $user->save();

            // Commit Transaction
            \DB::commit();

            return successMessage('account_info_updated');

        } catch (\Exception $e) {
            // Rollback Transaction
            \DB::rollBack();
            return errorMessage($e->getMessage(), true);
        }
    }

    public function updateProfileImage(Request $request)
    {
        $user = getTokenUser($request);

        $this->validate($request, [
            'profile_image' => 'required|' . config('cms.allowed_image_mimes'),
        ]);
        try {
            $user->profile_image = uploadFile('profile_image');
            $user->save();

            return successMessage('success', ['profile_image' => $user->profile_image]);

        } catch (\Exception $e) {
            return errorMessage($e->getMessage(), true);
        }
    }
}
