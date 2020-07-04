<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\WebController;
use Illuminate\Http\Request;

class DashboardController extends WebController
{
    public function getIndex(Request $request)
    {
        navigationMenuListing();
        return view('admin.dashboard.index');
    }

    public function getStats(Request $request)
    {
        $total_users = \App\Models\User::count();
        $total_coupons = \App\Models\Coupon::count();

        return response()->json(compact('total_users', 'total_coupons'));
    }

    public function getUsersGraph(Request $request)
    {
        $labels = $users = [];
        $date_range = getDaysBetweenDates($request->start_date, $request->end_date);

        $result = \App\Models\User::select(\DB::raw('COUNT(id) AS users, DATE(created_at) AS label'))
            ->whereBetween(\DB::raw('DATE(created_at)'), [$request->start_date, $request->end_date])
            ->groupBy(\DB::raw('DATE(created_at)'))
            ->pluck('users', 'label')
            ->toArray();

        foreach ($date_range as $date) {
            $labels[] = date('Y') == date('Y', strtotime($date)) ? date('d-M', strtotime($date)) : date('d-M-y', strtotime($date));
            $users[] = (int) @$result[$date];
        }

        return response()->json(compact('labels', 'users'));
    }

    public function getChangeLocale(Request $request)
    {
        \Session::put('lang', $request->lang);
        return redirect()->back();
    }
}
