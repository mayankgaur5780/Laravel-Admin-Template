<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        $user = getTokenUser($request);

        $this->validate($request, [
            'coupon_code' => 'required|exists:coupons',
            'total_amount' => 'required|numeric|min:1',
        ]);
        $dataArr = arrayFromPost($request, ['coupon_code', 'total_amount']);

        return successMessage('success', \App\Models\Coupon::validateCoupon($dataArr, $user));
    }
}
