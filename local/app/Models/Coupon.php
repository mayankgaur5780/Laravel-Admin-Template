<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $guarded = [];

    public static function validateCoupon($dataArr, $tokenUser)
    {
        $discount = $balance = 0;
        $coupon = \App\Models\Coupon::where('coupon_code', $dataArr->coupon_code)->first();

        // Check no of usage
        if ($coupon->per_user_usage > 0 && \App\Models\Booking::where(['user_id' => $tokenUser->id, 'coupon_code' => $dataArr->coupon_code])->count()) {
            return errorMessage('coupon_limit_exceeded');
        }

        // 1.Flat, 2.Percentage
        $discount = $coupon->type == 1 ? $coupon->discount : $dataArr->total_amount * $coupon->discount * 0.01;
        $discount = (float) ($coupon->type == 2 && $discount > $coupon->max_discount ? $coupon->max_discount : $discount);

        if ($dataArr->total_amount <= $discount) {
            return errorMessage('invalid_coupon');
        }

        $balance = $dataArr->total_amount - $discount;

        return compact('discount', 'balance');
    }
}
