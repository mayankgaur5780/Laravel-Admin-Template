<?php

if (!function_exists('array_from_post')) {
    function arrayFromPost($request, $fieldArr = [])
    {
        $output = new \stdClass;
        if (count($fieldArr)) {
            foreach ($fieldArr as $value) {
                $output->$value = $request->input($value);
            }
        }
        return $output;
    }
}

if (!function_exists('transLang')) {
    function transLang($template = '')
    {
        $output = '';
        if (!empty($template)) {
            $output = trans("messages.{$template}");
        }
        return $output;
    }
}

if (!function_exists('deleteFCMToken')) {
    function deleteFCMToken($device_id = false, $from = 'user')
    {
        if ($device_id) {
            $tokens = \App\Models\FcmToken::where('device_id', $device_id);
            if ($from == 'user') {
                $tokens->whereNotNull('user_id');
            } else {
                $tokens->whereNotNull('vendor_id');
            }
            return $tokens->delete();
        }
        return false;
    }
}

if (!function_exists('updateFCMToken')) {
    function updateFCMToken($dataArr = null, $column = 'user')
    {
        $fcmToken = new \stdClass;
        if ($dataArr == null) {
            return [
                'msg' => transLang('invalid_data_processed'),
                'errors' => ['error' => [transLang('invalid_data_processed')]],
            ];
        }

        $fcmToken = \App\Models\FcmToken::where('device_id', '=', $dataArr->device_id)->first();
        if ($fcmToken === null) {
            $fcmToken = new \App\Models\FcmToken();
        }

        if ($column == 'user') {
            $fcmToken->user_id = $dataArr->user_id;
        }

        $fcmToken->locale = $dataArr->locale;
        $fcmToken->fcm_id = $dataArr->fcm_id;
        $fcmToken->device_id = $dataArr->device_id;
        $fcmToken->device_type = $dataArr->device_type;
        $fcmToken->save();

        return [
            'status' => 1,
            'data' => $fcmToken,
        ];
    }
}

if (!function_exists('sendPushNotification')) {
    function sendPushNotification($fcm_id = [], $dataArr = [])
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $api_key = config('cms.fcm_legacy_key');
        $notification = [
            'title' => @$dataArr['title'],
            'en_title' => @$dataArr['en_title'],
            'body' => @$dataArr['body'],
            'en_body' => @$dataArr['en_body'],
            'extra_data' => $dataArr,
        ];

        $arrayToSend = [
            'registration_ids' => is_array($fcm_id) ? $fcm_id : [$fcm_id],
            'priority' => "high",
            'data' => $notification,
            'content_available' => true,
        ];

        $headers = [
            'Content-Type:application/json',
            "Authorization:key={$api_key}",
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arrayToSend));

        $result = curl_exec($ch);
        if ($result === false) {
            $result = curl_error($ch);
        }
        curl_close($ch);

        return $result;
    }
}

if (!function_exists('sendNotification')) {
    function sendNotification($users = [], $dataArr, $column = 'user_id', $send_fcm = true)
    {
        if (env('ALLOW_SEND_NOTIFICATIONS')) {
            $users = is_array($users) ? $users : [$users];

            $dataArr['notification_type'] = isset($dataArr['notification_type']) ? $dataArr['notification_type'] : 0;
            $dataArr['save_data'] = isset($dataArr['save_data']) ? $dataArr['save_data'] : true;

            // Save Notification In DB
            $notification = [];
            $notification['title'] = @$dataArr['title'];
            $notification['en_title'] = @$dataArr['en_title'];
            $notification['message'] = @$dataArr['body'];
            $notification['en_message'] = @$dataArr['en_body'];
            if (isset($dataArr['attribute'])) {
                $notification['attribute'] = $dataArr['attribute'];
                $notification['value'] = $dataArr['value'];
            }
            $notification['notification_type'] = $dataArr['notification_type'];
            $notification['created_at'] = date('Y-m-d H:i:s');
            $notification['updated_at'] = date('Y-m-d H:i:s');

            if ($dataArr['save_data'] == true) {
                $notificationArr = [];
                foreach ($users as $id) {
                    $notification[$column] = $id;
                    $notificationArr[] = $notification;
                }

                try {
                    \App\Models\Notification::insert($notificationArr);
                } catch (\Exception $e) {
                    $data = [
                        'message' => $e->getMessage(),
                        'error' => $e,
                    ];
                    \Log::error(json_encode($data));
                }
            }

            if ($send_fcm) {
                $tokens = \App\Models\FcmToken::whereIn($column, $users)->pluck('fcm_id')->toArray();
                return sendPushNotification($tokens, $dataArr);
            }
        }
        return true;
    }
}

if (!function_exists('generateOtp')) {
    function generateOtp()
    {
        return 7838;
        return rand(1000, 9999);
    }
}

if (!function_exists('sendOtpToUser')) {
    function sendOtpToUser($user_id = false)
    {
        $user = \App\Models\User::find($user_id);
        if ($user != null) {
            $otp = generateOtp();
            $user->otp = $otp;
            $user->otp_generated_at = date('Y-m-d H:i:s');
            $user->save();

            // $message = "يرجى استخدام {$otp} المدعي العام كمكتب المدعي العام للتحقق من رقم هاتفك النقال.";
            // sendOtp($user->mobile, $message);
            return $user->otp;
        }
        return false;
    }
}

if (!function_exists('sendOtp')) {
    function sendOtp($mobile = false, $message = false)
    {
        $url = 'http://www.kingsms.ws/api/sendsms.php?username=services&password=abcdef';
        $url .= '&message=' . urlencode($message);
        $url .= '&numbers=' . urlencode($mobile);
        $url .= '&sender=S-Booking';
        $url .= '&unicode=e';
        $url .= '&return=xml';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        if ($result === false) {
            throw new Exception(curl_error($ch), curl_errno($ch));
        }
        curl_close($ch);
        return json_decode(json_encode(simplexml_load_string($result)));
    }
}

if (!function_exists('getLocales')) {
    function getLocales()
    {
        return ['en', 'ar'];
    }
}

if (!function_exists('processUserResponseData')) {
    function processUserResponseData($user_id = false, $device_id = false, $user = null)
    {
        $output = new \stdClass;
        if ($user_id || $user) {
            $user = $user == null ? \App\Models\User::find($user_id) : $user;

            if ($user != null) {
                /* $user->fcmData = new \stdClass();
                if ($device_id) {
                $user->fcmData = getUserFCMToken($user->id, $device_id);
                } */
                unset($user->password, $user->remember_token, $user->otp, $user->otp_generated_at);
                $output = $user;
            }
        }
        return $output;
    }
}

if (!function_exists('successMessage')) {
    function successMessage($template = 'request_processed_successfully', $dataArr = null, $httpCode = 200)
    {
        $output = new \stdClass;
        $output->message = transLang($template);
        if ($dataArr != null) {
            $output->data = $dataArr;
        }
        return response()->json($output, $httpCode);
    }
}

if (!function_exists('errorMessage')) {
    function errorMessage($template = '', $string = false)
    {
        $message = !$string ? transLang($template) : $template;

        return response()->json([
            'message' => transLang('given_data_invalid'),
            'errors' => ['error' => [$message]],
        ], 422);
    }
}

if (!function_exists('generateFilename')) {
    function generateFilename()
    {
        return str_replace([' ', ':', '-'], '', \Carbon\Carbon::now()->toDateTimeString()) . generateRandomString(10, 'lower_case,upper_case,numbers');
    }
}

if (!function_exists('generateRandomString')) {
    function generateRandomString($length = 6, $characters = 'upper_case,lower_case,numbers')
    {
        // $length - the length of the generated password
        // $count - number of passwords to be generated
        // $characters - types of characters to be used in the password

        // define variables used within the function
        $symbols = array();
        $passwords = array();
        $used_symbols = '';
        $pass = '';

        // an array of different character types
        $symbols['lower_case'] = 'abcdefghijklmnopqrstuvwxyz';
        $symbols['upper_case'] = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $symbols['numbers'] = '1234567890';
        $symbols['special_symbols'] = '!?~@#-_+<>[]{}';

        $characters = explode(',', $characters); // get characters types to be used for the password
        foreach ($characters as $key => $value) {
            $used_symbols .= $symbols[$value]; // build a string with all characters
        }
        $symbols_length = strlen($used_symbols) - 1; //strlen starts from 0 so to get number of characters deduct 1

        for ($p = 0; $p < 1; ++$p) {
            $pass = '';
            for ($i = 0; $i < $length; ++$i) {
                $n = rand(0, $symbols_length); // get a random character from the string with all characters
                $pass .= $used_symbols[$n]; // add the character to the password string
            }
            $passwords = $pass;
        }

        return $passwords; // return the generated password
    }
}

if (!function_exists('getTimeDiff')) {
    function getTimeDiff($input = '')
    {
        return $input ? \Carbon::createFromTimeStamp(strtotime($input))->diffForHumans() : '';
    }
}

if (!function_exists('formatDateTime')) {
    function formatDateTime($input = '', $to_format = 'Y-m-d H:i:s', $from_format = 'Y-m-d H:i:s')
    {
        return $input ? \Carbon::createFromFormat($from_format, $input)->format($to_format) : '';
    }
}

if (!function_exists('calculateVendorRating')) {
    function calculateVendorRating($vendor_id = false, $total_voters = true)
    {
        if ($vendor_id) {
            return null;
        }

        $voters = $rating = 0;
        $response = \App\Models\UserReview::select(\DB::raw('COUNT(*) AS total, SUM(rating) AS rating'))
            ->where('vendor_id', $vendor_id)
            ->first();
        if (!blank($response)) {
            $voters = $response->total;
            $rating = $response->rating ? round($response->rating / $response->total, 1) : 0;
        }

        if ($total_voters) {
            return (object) ['voters' => $voters, 'rating' => $rating];
        }

        return $rating;
    }
}

if (!function_exists('filterMobileNo')) {
    function filterMobileNo($mobile = null, $dial_code = null)
    {
        if (!$mobile || !$dial_code) {
            return '';
        }

        $mobile = str_replace('+', '', $mobile);
        if (substr($mobile, 0, strlen($dial_code)) === $dial_code) {
            $mobile = substr($mobile, strlen($dial_code));
        } elseif (substr($mobile, 0, 1) == "0") {
            $mobile = substr($mobile, 1);
        }

        return $mobile;
    }
}

if (!function_exists('getTokenUser')) {
    function getTokenUser($request, $force_login = true)
    {
        $tokenUser = null;
        if ($request->header('Authorization')) {
            if (!$tokenUser = \JWTAuth::parseToken()->authenticate()) {
                errorMessage('user_not_logged_in');
            }
        }
        if ($tokenUser == null && $force_login) {
            errorMessage('user_not_logged_in');
        }
        return $tokenUser;
    }
}

if (!function_exists('sendEmail')) {
    function sendEmail($file, $subject, $to_email, $configArr = [])
    {
        if (blank($to_email)) {
            return false;
        }

        if (env('ALLOW_SEND_EMAIL')) {
            try {
                return \Mail::send("email_templates.en.{$file}", $configArr, function ($message) use ($to_email, $subject) {
                    $message->subject($subject)
                        ->to($to_email);
                });
            } catch (\Exception $e) {
                \Log::error($e->getMessage());
                return $e->getMessage();
            }
        }
    }
}

if (!function_exists('generateBookingCode')) {
    function generateBookingCode()
    {
        // return 'KW' . microtime(true) * 10000 . getRandomNumber(4);
        return 'KW' . getRandomNumber(4);
    }
}

if (!function_exists('getBtwDays')) {
    function getBtwDays($from_date = null, $to_date = null)
    {
        if (!$from_date || !$to_date) {
            return 0;
        }

        $from_date = new \DateTime($from_date);
        $to_date = new \DateTime($to_date);
        $interval = $from_date->diff($to_date);
        return $interval->format('%a');
    }
}

if (!function_exists('generateRefCode')) {
    function generateRefCode()
    {
        $referralCode = getRandomNumber();
        if (\App\Models\User::where('referral_code', $referralCode)->count()) {
            return generateRefCode();
        } else {
            return $referralCode;
        }
    }
}

if (!function_exists('getRandomNumber')) {
    function getRandomNumber($digits = 6)
    {
        return rand(pow(10, $digits - 1), pow(10, $digits) - 1);
    }
}

if (!function_exists('getAppSetting')) {
    function getAppSetting($attribute = false)
    {
        if (!$attribute) {
            return null;
        }

        $setting = \App\Models\Setting::select('value')->where('attribute', $attribute)->first();
        return $setting != null ? $setting->value : null;
    }
}

if (!function_exists('getDaysBetweenDates')) {
    function getDaysBetweenDates($startDate, $endDate, $format = 'Y-m-d')
    {
        $response = [];
        $period = \Carbon\CarbonPeriod::create($startDate, $endDate);

        foreach ($period as $date) {
            $response[] = $date->format($format);
        }
        return $response;
    }
}

if (!function_exists('strpos_arr')) {
    function strpos_arr($haystack, $needle)
    {
        $response = [];
        $needle = !is_array($needle) ? [$needle] : $needle;

        foreach ($needle as $key => $what) {
            if (($pos = strpos($what, $haystack)) !== false) {
                $response[] = $key;
            }

        }
        return $response;
    }
}

if (!function_exists('setJWTSettings')) {
    function setJWTSettings()
    {
        // Change default guard
        \Config::set('auth.defaults', [
            'guard' => 'vendor',
            'passwords' => 'vendor',
        ]);
    }
}

if (!function_exists('compareNumbers')) {
    function compareNumbers($number1, $number2)
    {
        if ($number2) {
            return (abs(($number1 - $number2) / $number2) < 0.00001);
        }
        return ((double) $number1 == (double) $number2);
    }
}

if (!function_exists('getSessionLang')) {
    function getSessionLang($session = 'admin')
    {
        $keyArr = ['admin' => 'admin_lang'];
        return \Session::get($keyArr[$session]);
    }
}

if (!function_exists('getCustomSessionLang')) {
    function getCustomSessionLang($session = 'admin')
    {
        $keyArr = ['admin' => 'admin_lang'];
        return \Session::get($keyArr[$session]) == 'en' ? 'en_' : '';
    }
}
