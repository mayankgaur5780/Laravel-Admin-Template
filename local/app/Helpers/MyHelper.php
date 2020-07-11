<?php

if (!function_exists('array_from_post')) {
    function arrayFromPost($fieldArr = [])
    {
        $request = request();
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
    function transLang($template = null, $dataArr = [])
    {
        return $template ? trans("messages.{$template}", $dataArr) : '';
    }
}

if (!function_exists('deleteFCMToken')) {
    function deleteFCMToken($device_id = false, $from = 'user')
    {
        if ($device_id) {
            \App\Models\FcmToken::where('device_id', $device_id)
                ->when($from == 'user', function ($query) {
                    $query->whereNotNull('user_id');
                })
                ->when($from != 'user', function ($query) {
                    $query->whereNotNull('vendor_id');
                })
                ->delete();

            return true;
        }
        return false;
    }
}

if (!function_exists('updateFCMToken')) {
    function updateFCMToken($dataArr = null, $column = 'user')
    {
        $fcmToken = new \stdClass;
        if ($dataArr == null) {
            return false;
        }

        $fcmToken = \App\Models\FcmToken::where('device_id', '=', $dataArr->device_id)->first();
        if ($fcmToken === null) {
            $fcmToken = new \App\Models\FcmToken();
        }

        $fcmToken->{"{$column}_id"} = $dataArr->{"{$column}_id"};
        $fcmToken->fcm_id = $dataArr->fcm_id;
        $fcmToken->device_id = $dataArr->device_id;
        $fcmToken->device_type = $dataArr->device_type;
        $fcmToken->save();

        return $fcmToken;
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
        $url = 'http://www.kingsms.ws/api/sendsms.php?username=&password=';
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
    function processUserResponseData($user = null, $access_token = null)
    {
        $output = new \stdClass;
        if (!blank($access_token)) {
            $output->access_token = $access_token;
            $output->token_type = 'bearer';
            $output->expires_in = (env('JWT_TTL') * 60);
            $output->expires_unit = 'Seconds';
        }

        if ($user != null) {
            unset($user->password, $user->remember_token, $user->otp, $user->otp_generated_at);

            if (!blank($access_token)) {
                $output->data = $user;
            } else {
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

if (!function_exists('exceptionErrorMessage')) {
    function exceptionErrorMessage($e, $throw_exception = false)
    {
        \Log::error($e);
        return errorMessage('session_expire', false, $throw_exception);
    }
}

if (!function_exists('errorMessage')) {
    function errorMessage($template = '', $string = false, $throw_exception = false)
    {
        $message = !$string ? transLang($template) : $template;

        if ($throw_exception) {
            $validator = \Validator::make([], []);
            $validator->errors()->add('error', $message);
            throw new \Illuminate\Validation\ValidationException($validator);
        }

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
    function getTokenUser($force_login = true)
    {
        $request = request();
        $tokenUser = null;
        if ($request->header('Authorization')) {
            if (!$tokenUser = \JWTAuth::parseToken()->authenticate()) {
                throw new \Tymon\JWTAuth\Exceptions\TokenExpiredException();
            }
        }
        if ($tokenUser == null && $force_login) {
            throw new \Tymon\JWTAuth\Exceptions\TokenExpiredException();
        } elseif ($tokenUser != null && $tokenUser->status != 1) {
            throw new \Tymon\JWTAuth\Exceptions\TokenExpiredException();
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
                \Log::error($e);
                return $e->getMessage();
            }
        }
    }
}

if (!function_exists('generateBookingCode')) {
    function generateBookingCode()
    {
        return 'PROJ' . getRandomNumber(4);
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
        $keyArr = ['admin' => 'lang'];
        return \Session::get($keyArr[$session]);
    }
}

if (!function_exists('getCustomSessionLang')) {
    function getCustomSessionLang($locale = null)
    {
        $locale = is_null($locale) ? getSessionLang() : $locale;
        return $locale == 'ar' ? '' : "{$locale}_";
    }
}

if (!function_exists('buildHierarchyTree')) {
    function buildHierarchyTree($elements, $parentId = null)
    {
        $branch = collect();

        foreach ($elements as $element) {
            if ($element->parent_id == $parentId) {
                $children = buildHierarchyTree($elements, $element->id);
                if ($children->count()) {
                    $element->children = $children;
                }
                $branch->add($element);
            }
        }

        return $branch;
    }
}

if (!function_exists('apiResponse')) {
    function apiResponse($template = 'success', $dataArr = null, $httpCode = 200)
    {
        $output = new \stdClass;
        $output->message = transLang($template);
        !$dataArr || $output->data = $dataArr;
        return response()->json($output, $httpCode);
    }
}

if (!function_exists('decodeUnicodeString')) {
    function decodeUnicodeString($string)
    {
        return preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function ($match) {
            return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
        }, $string);
    }
}
