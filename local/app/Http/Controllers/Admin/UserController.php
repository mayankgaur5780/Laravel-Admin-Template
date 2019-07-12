<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getIndex()
    {
        return view('admin.users.index');
    }

    public function getList()
    {
        $users = \App\Models\User::select(['id', 'name', 'email', 'dial_code', 'mobile', 'status', 'created_at']);
        return \DataTables::of($users)
            ->filterColumn('created_at', function ($query, $keyword) {
                $query->whereRaw("created_at like ?", ["%$keyword%"]);
            })
            ->filterColumn('mobile', function ($query, $keyword) {
                $query->whereRaw("CONCAT(dial_code, ' ', mobile) like ?", ["%$keyword%"]);
            })
            ->editColumn('status', function ($query) {
                return transLang('action_status')[$query->status];
            })
            ->filterColumn('status', function ($query, $keyword) {
                $keyword = strtolower($keyword) == "active" ? 1 : 0;
                $query->where("status", $keyword);
            })
            ->make();
    }

    public function getCreate()
    {
        return view('admin.users.create');
    }

    public function postCreate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'dial_code' => 'required|numeric|digits_between:1,5',
            'mobile' => 'required|numeric|digits_between:9,20',
            'email' => 'nullable|email',
            'password' => 'required|min:6',
            'gender' => 'nullable',
            'dob' => 'nullable|date_format:Y-m-d',
            'address' => 'nullable',
            'profile_image' => config('cms.allowed_image_mimes'),
        ]);
        $dataArr = arrayFromPost($request, ['name', 'email', 'dial_code', 'mobile', 'password', 'gender', 'dob', 'address', 'status']);

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
            $user->gender = $dataArr->gender;
            $user->dob = $dataArr->dob ? date('Y-m-d', strtotime($dataArr->dob)) : null;
            $user->address = $dataArr->address;
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
        return view('admin.users.update', compact('user'));
    }

    public function postUpdate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'nullable|email',
            'dial_code' => 'required|numeric|digits_between:1,5',
            'mobile' => 'required|numeric|digits_between:9,20',
            'gender' => 'nullable',
            'dob' => 'nullable|date_format:Y-m-d',
            'address' => 'nullable',
            'profile_image' => config('cms.allowed_image_mimes'),
        ]);
        $dataArr = arrayFromPost($request, ['name', 'email', 'dial_code', 'mobile', 'gender', 'dob', 'address', 'status']);

        // Check Mobile No Duplicate
        if (\App\Models\User::where('dial_code', $dataArr->dial_code)->where('mobile', $dataArr->mobile)->where('id', '<>', $request->id)->count()) {
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
            $user->gender = $dataArr->gender;
            $user->dob = $dataArr->dob ? date('Y-m-d', strtotime($dataArr->dob)) : null;
            $user->address = $dataArr->address;
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
