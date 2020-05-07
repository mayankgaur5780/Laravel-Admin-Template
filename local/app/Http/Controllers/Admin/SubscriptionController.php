<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\WebController;
use Illuminate\Http\Request;

class SubscriptionController extends WebController
{
    public function getIndex()
    {
        return view('admin.subscriptions.index');
    }

    public function getList()
    {
        $list = \App\Models\Subscription::select('*');

        return \DataTables::of($list)
            ->addColumn('status_text', function ($query) {
                return transLang('action_status')[$query->status];
            })
            ->addColumn('duration_text', function ($query) {
                return transLang('subscription_days')[$query->duration];
            })
            ->filterColumn('duration', function ($query, $keyword) {
                $keyword = strpos_arr(strtolower($keyword), transLang('subscription_days'));
                if (!blank($keyword)) {
                    $query->whereIn('duration', $keyword);
                }
            })
            ->make();
    }

    public function getCreate()
    {
        return view('admin.subscriptions.create');
    }

    public function postCreate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'en_name' => 'required|unique:subscriptions,en_name',
            'price' => 'required|numeric|min:1',
            'duration' => 'required|numeric|min:0',
            'status' => 'required',
        ]);
        $dataArr = arrayFromPost(['name', 'en_name', 'price', 'duration', 'status']);

        $subscription = new \App\Models\Subscription();
        $subscription->name = $dataArr->name;
        $subscription->en_name = $dataArr->en_name;
        $subscription->price = $dataArr->price;
        $subscription->duration = $dataArr->duration;
        $subscription->status = $dataArr->status;
        $subscription->save();

        return successMessage();
    }

    public function getUpdate(Request $request)
    {
        $subscription = \App\Models\Subscription::findOrFail($request->id);
        return view('admin.subscriptions.update', compact('subscription'));
    }

    public function postUpdate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'en_name' => "required|unique:subscriptions,en_name,{$request->id},id",
            'price' => 'required|numeric|min:1',
            'duration' => 'required|numeric|min:0',
            'status' => 'required',
        ]);
        $dataArr = arrayFromPost(['name', 'en_name', 'price', 'duration', 'status']);

        $subscription = \App\Models\Subscription::find($request->id);
        if ($subscription != null) {
            $subscription->name = $dataArr->name;
            $subscription->en_name = $dataArr->en_name;
            $subscription->price = $dataArr->price;
            $subscription->duration = $dataArr->duration;
            $subscription->status = $dataArr->status;
            $subscription->save();
        }

        return successMessage();
    }

    public function getDelete(Request $request)
    {
        \App\Models\Subscription::find($request->id)->delete();
        return successMessage();
    }
}
