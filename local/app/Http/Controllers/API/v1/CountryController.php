<?php

namespace App\Http\Controllers\API\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CountryController extends Controller
{
    public function index(Request $request)
    {
        $list = \App\Models\Country::select(\DB::raw("id, country_name, en_country_name, dial_code, currency, flag, tax"))
            ->orderBy('en_country_name', 'ASC')
            ->where('status', 1)
            ->get();
        
        return successMessage('success', $list);
    }
}
