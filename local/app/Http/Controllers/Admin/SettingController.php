<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\WebController;
use Illuminate\Http\Request;

class SettingController extends WebController
{
    public function getIndex(Request $request)
    {
        abort_unless(hasPermission('admin/settings'), 401);

        $settings = \App\Models\Setting::all();
        return view('admin.settings.index', compact('settings'));
    }

    public function postUpdate(Request $request)
    {
        $this->validate($request, [
            'tax_percentage' => 'required|numeric|gte:0|lte:100',
        ]);
        $dataArr = arrayFromPost(['tax_percentage']);

        try {
            // Start Transaction
            \DB::beginTransaction();

            foreach ($dataArr as $key => $value) {
                \App\Models\Setting::where('attribute', $key)
                    ->update(['value' => $value]);
            }

            // Commit Transaction
            \DB::commit();

            return successMessage();
        } catch (\Throwable $th) {
            // Rollback Transaction
            \DB::rollBack();
            return exceptionErrorMessage($th);
        }
    }
}
