<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\WebController;
use Illuminate\Http\Request;

class DashboardController extends WebController
{
    public function getIndex()
    {
        // navigationMenuListing();
        return view('admin.dashboard.index');
    }

    public function getStats(Request $request)
    {
        $total_users = \App\Models\User::count();
        $total_coupons = \App\Models\Coupon::count();

        return response()->json(compact('total_users', 'total_coupons'));
    }

    public function getSubscriptionsGraph(Request $request)
    {
        $labels = $subscriptions = [];
        $date_range = getDaysBetweenDates($request->start_date, $request->end_date);

        $status_arr = blank($request->status) ? [1, 2, 3, 4] : $request->status;

        foreach ($date_range as $date) {
            $result = \App\Models\SubscriptionHistory::where('payment_date', $date)
                ->groupBy('payment_date')
                ->count();

            $labels[] = date('Y') == date('Y', strtotime($date)) ? date('d-M', strtotime($date)) : date('d-M-y', strtotime($date));
            $subscriptions[] = $result;
        }

        if (blank(array_filter($subscriptions))) {
            $subscriptions = [];
        }

        $stats = [];
        $stats['total_subscriptions_amount'] = number_format(\App\Models\SubscriptionHistory::whereBetween(\DB::raw('DATE(created_at)'), [$request->start_date, $request->end_date])
                ->sum('amount'), 2);

        return response()->json(compact('labels', 'subscriptions', 'stats'));
    }

    public function getChangeLocale(Request $request)
    {
        \Session::put('lang', $request->lang);
        return redirect()->back();
    }
}
