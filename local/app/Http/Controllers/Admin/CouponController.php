<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function getIndex()
    {
        return view('admin.coupons.index');
    }

    public function getList()
    {
        $list = \App\Models\Coupon::select('*');

        return \DataTables::of($list)
            ->editColumn('status', function ($query) {
                return transLang('action_status')[$query->status];
            })->make();
    }

    public function getCreate()
    {
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
        $dataArr = arrayFromPost($request, ['coupon_code', 'type', 'discount', 'max_discount', 'valid_from', 'valid_to', 'per_user_usage', 'status']);

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
    }

    public function getUpdate($id = null)
    {
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
        $dataArr = arrayFromPost($request, ['coupon_code', 'type', 'discount', 'max_discount', 'valid_from', 'valid_to', 'per_user_usage', 'status']);

        $coupon = \App\Models\Coupon::find($request->id);
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
    }

    public function getDelete(Request $request)
    {
        \App\Models\Coupon::find($request->id)->delete();
        return successMessage();
    }
}
