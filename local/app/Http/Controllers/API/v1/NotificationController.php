<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $user = getTokenUser($request);

        $list = \App\Models\Notification::select('*')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        return successMessage('success', $list);
    }

    public function delete(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|numeric|exists:notifications',
        ]);
        $dataArr = arrayFromPost($request,['id']);

        \App\Models\Notification::find($dataArr->id)->delete();
        return successMessage('success');
    }

    public function deleteAll(Request $request)
    {
        $user = getTokenUser($request);
        \App\Models\Notification::where('user_id', $user->id)->delete();
        return successMessage('success');
    }

    // Vendor Functions
    public function vendorNotifications(Request $request)
    {
        $user = getTokenVendor($request, true);

        $list = \App\Models\Notification::select('*')
            ->where('vendor_id', $user->id)
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        return successMessage('success', $list);
    }

    public function deleteAllVendorNotifications(Request $request)
    {
        $user = getTokenVendor($request, true);
        \App\Models\Notification::where('vendor_id', $user->id)->delete();
        return successMessage('success');
    }
}
