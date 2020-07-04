<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\WebController;
use Illuminate\Http\Request;

class CouponController extends WebController
{
    public function getIndex(Request $request)
    {
        abort_unless(hasPermission('admin/coupons'), 401);

        return view('admin.coupons.index');
    }

    public function getList(Request $request)
    {
        $list = \App\Models\Coupon::select('*');

        return \DataTables::of($list)
            ->addColumn('status_text', function ($query) {
                return transLang('action_status')[$query->status];
            })
            ->make();
    }

    public function getCreate(Request $request)
    {
        abort_unless(hasPermission('create_coupon'), 401);

        return view('admin.coupons.create');
    }

    public function postCreate(Request $request)
    {
        $this->validate($request, [
            'coupon_code' => 'required|unique:coupons',
            'type' => 'required',
            'discount' => 'required|numeric|min:1',
            'max_discount' => $request->type == 2 ? 'required|numeric|min:1' : 'nullable',
            'valid_from' => 'required|after_or_equal:today|date_format:Y-m-d',
            'valid_to' => 'required|after_or_equal:valid_from|date_format:Y-m-d',
            'per_user_usage' => 'required|numeric|min:0',
            'status' => 'required',
        ]);
        $dataArr = arrayFromPost(['coupon_code', 'type', 'discount', 'max_discount', 'valid_from', 'valid_to', 'per_user_usage', 'status']);

        try {
            $coupon = new \App\Models\Coupon();
            $coupon->coupon_code = $dataArr->coupon_code;
            $coupon->type = $dataArr->type;
            $coupon->discount = $dataArr->discount;
            $coupon->max_discount = $dataArr->type == 2 ? $dataArr->max_discount : null;
            $coupon->valid_from = date('Y-m-d', strtotime($dataArr->valid_from));
            $coupon->valid_to = date('Y-m-d', strtotime($dataArr->valid_to));
            $coupon->per_user_usage = $dataArr->per_user_usage;
            $coupon->status = $dataArr->status;
            $coupon->save();

            return successMessage();
        } catch (\Throwable $th) {
            return exceptionErrorMessage($th);
        }
    }

    public function getUpdate($id = null)
    {
        abort_unless(hasPermission('update_coupon'), 401);

        $coupon = \App\Models\Coupon::findOrFail($id);
        return view('admin.coupons.update', compact('coupon'));
    }

    public function postUpdate(Request $request)
    {
        $this->validate($request, [
            'coupon_code' => "required|unique:coupons,coupon_code,{$request->id},id",
            'type' => 'required',
            'discount' => 'required|numeric|min:1',
            'max_discount' => $request->type == 2 ? 'required|numeric|min:1' : 'nullable',
            'valid_from' => 'required|date_format:Y-m-d',
            'valid_to' => 'required|after_or_equal:valid_from|date_format:Y-m-d',
            'per_user_usage' => 'required|numeric|min:0',
            'status' => 'required',
        ]);
        $dataArr = arrayFromPost(['coupon_code', 'type', 'discount', 'max_discount', 'valid_from', 'valid_to', 'per_user_usage', 'status']);

        try {
            $coupon = \App\Models\Coupon::find($request->id);
            if (!blank($coupon)) {
                $coupon->coupon_code = $dataArr->coupon_code;
                $coupon->type = $dataArr->type;
                $coupon->discount = $dataArr->discount;
                $coupon->max_discount = $dataArr->type == 2 ? $dataArr->max_discount : null;
                $coupon->valid_from = date('Y-m-d', strtotime($dataArr->valid_from));
                $coupon->valid_to = date('Y-m-d', strtotime($dataArr->valid_to));
                $coupon->per_user_usage = $dataArr->per_user_usage;
                $coupon->status = $dataArr->status;
                $coupon->save();
            }

            return successMessage();
        } catch (\Throwable $th) {
            return exceptionErrorMessage($th);
        }
    }

    public function getDelete(Request $request)
    {
        abort_unless(hasPermission('delete_coupon'), 401);

        \App\Models\Coupon::find($request->id)->delete();
        return successMessage();
    }
}
