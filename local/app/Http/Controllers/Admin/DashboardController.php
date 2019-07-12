<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function getIndex()
    {
        // navigationMenuListing();

        $users = \App\Models\User::select(\DB::raw('id, CONCAT(name, " (+", dial_code, " ", mobile, ")") AS name'))->where('status', 1)->orderBy('name')->get();

        return view('admin.dashboard.index', compact('users'));
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
        \Session::put('admin_lang', $request->lang);
        return redirect()->back();
    }
}
