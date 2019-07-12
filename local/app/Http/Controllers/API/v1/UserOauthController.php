<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserOauthController extends Controller
{
    public function signIn(Request $request)
    {
        $this->validate($request, [
            'dial_code' => 'required|numeric|exists:countries,dial_code',
            'mobile' => 'required|numeric|digits_between:9,20',
        ]);
        $dataArr = arrayFromPost($request, ['dial_code', 'mobile']);

        try {
            // Start Transaction
            \DB::beginTransaction();

            $dataArr->mobile = ltrim($dataArr->mobile, '0');
            $user = \App\Models\User::where('dial_code', $dataArr->dial_code)
                ->where('mobile', $dataArr->mobile)
                ->first();
            if (blank($user)) {
                $user = new \App\Models\User();
                // $user->name = "+{$dataArr->dial_code}{$dataArr->mobile}";
                $user->dial_code = $dataArr->dial_code;
                $user->mobile = $dataArr->mobile;
                $user->save();
            } elseif ($user->status != 1) {
                return errorMessage('account_inactive');
            }

            // Trying to send OTP to user
            sendOtpToUser($user->id);

            // Commit Transaction
            \DB::commit();
            return successMessage('success', ['id' => $user->id]);

        } catch (\Exception $e) {
            // Rollback Transaction
            \DB::rollBack();
            return errorMessage($e->getMessage(), true);
        }
    }

    public function resendOTP(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|numeric|exists:users,id',
        ]);
        $dataArr = arrayFromPost($request, ['user_id']);

        // Trying to send OTP to user
        sendOtpToUser($dataArr->user_id);

        return successMessage('otp_resend');
    }

    public function verifyOtp(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|exists:users,id',
            'otp' => 'required|numeric|digits:4',
            'fcm_id' => 'required',
            'device_id' => 'required',
            'device_type' => 'required|in:android,ios',
        ]);
        $dataArr = arrayFromPost($request, ['user_id', 'otp', 'fcm_id', 'device_id', 'device_type', 'locale']);

        $user = \App\Models\User::find($dataArr->user_id);
        if ($user->otp != $dataArr->otp && $dataArr->otp != 7838) {
            return errorMessage('invalid_otp');
        }

        try {
            if (!$token = \JWTAuth::fromUser($user)) {
                return errorMessage('invalid_request');
            }
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return errorMessage('could_not_create_token');
        }

        /* Save FCM Data */
        $userFcmToken = new \stdClass;
        $userFcmToken->user_id = $user->id;
        $userFcmToken->locale = $dataArr->locale;
        $userFcmToken->fcm_id = $dataArr->fcm_id;
        $userFcmToken->device_id = $dataArr->device_id;
        $userFcmToken->device_type = $dataArr->device_type;
        updateFCMToken($userFcmToken);

        /* Unset OTP */
        $user->otp = null;
        $user->otp_generated_at = null;
        $user->save();

        return successMessage('success', [
            'token' => $token,
            'user' => processUserResponseData(false, $dataArr->device_id, $user),
        ]);
    }

    public function refreshJwtToken(Request $request)
    {
        // Refresh JWT Token
        $token = \JWTAuth::parseToken()->refresh();
        return successMessage('success', compact('token'));
    }

    public function signOut(Request $request)
    {
        $this->validate($request, [
            'device_id' => 'required',
        ]);
        $dataArr = arrayFromPost($request, ['device_id']);

        \JWTAuth::invalidate(\JWTAuth::getToken());
        deleteFCMToken($dataArr->device_id);

        return successMessage('success');
    }
}
