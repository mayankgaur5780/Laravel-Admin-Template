<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CmsController extends Controller
{
    public function getAboutUs(Request $request)
    {
        $list = \App\Models\AppCms::select(\DB::raw("content, en_content"))
            ->where('attribute', 'about_us')
            ->first();

        return successMessage('success', $list);
    }

    public function getTermsCondition(Request $request)
    {
        $list = \App\Models\AppCms::select(\DB::raw("content, en_content"))
            ->where('attribute', 'terms_condition')
            ->first();

        return successMessage('success', $list);
    }

    public function getPrivacyPolicy(Request $request)
    {
        $list = \App\Models\AppCms::select(\DB::raw("content, en_content"))
            ->where('attribute', 'privacy_policy')
            ->first();

        return successMessage('success', $list);
    }

    public function getFaq(Request $request)
    {
        $list = \App\Models\Faq::select(\DB::raw("title, en_title, content, en_content"))
            ->orderBy('en_title')
            ->get();

        return successMessage('success', $list);
    }
}
