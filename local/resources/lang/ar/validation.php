<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
     */

    'accepted' => 'يجب الموافقة على :attribute',
    'active_url' => ':attribute رابط غير صحيح .',
    'after' => 'يجب أن يكون :attribute تاريخاً بعد :date.',
    'after_or_equal' => 'يجب أن يكون :attribute تاريخاً بعد أو يساوي :date.',
    'alpha' => ':attribute يجب أن تحتوي على أحرف فقط',
    'alpha_dash' => ':attribute يجب أن تحتوي على أحرف وأرقام و شَرطة فقط',
    'alpha_num' => ':attribute يجب أن تحتوي على أحرف وأرقام فقط',
    'array' => ':attribute يجب أن تكون مصفوفة',
    'before' => ':attribute يجب أن يكون تاريخ قبل :date.',
    'before_or_equal' => ':attribute يجب أن يكون تاريخ قبل أو يساوي :date.',
    'between' => [
        'numeric' => ':attribute يجب أن يكون بين :min و :max.',
        'file' => ':attribute يجب أن يكون بين :min و :max كيلوبايت.',
        'string' => ' :attribute يجب أن يكون بين :min و :max من الأحرف.',
        'array' => ':attribute يجب أن يحتوي على عناصر بين :min و :max .',
    ],
    'boolean' => 'حقل :attribute يجب أن يكون صح أو خطأ.',
    'confirmed' => 'تأكيد :attribute غير متطابق .',
    'date' => ':attribute ليس تاريخاً صحيحاً.',
    'date_equals' => ':attribute يجب أن يكون تاريخاً يساوي :date .',
    'date_format' => ':attribute لا يتطابق مع تنسيق :format.',
    'different' => ':attribute يجب أن يكون مختلف عن :other .',
    'digits' => ':attribute يجب أن يكون :digits  رقم .',
    'digits_between' => ':attribute يجب أن يكون بين :min و :max من الأرقام',
    'dimensions' => ':attribute أبعاد الصورة غير صالحة .',
    'distinct' => ':attribute يحتوي على قيمة مكررة.',
    'email' => ':attribute يجب أن يكون بريد إلكتروني صحيح ',
    'ends_with' => ':attribute يجب أن تنتهي بإحدى القيم :values',
    'exists' => ':attribute المحددة غير صحيحة.',
    'file' => ':attribute يجب أن يكون ملف.',
    'filled' => ':attribute يجب أن يحتوي على قيمة.',
    'gt' => [
        'numeric' => ':attribute يجب أن يكون أكبر من :value .',
        'file' => ':attribute يجب أن يكون أكبر من :value كيلوبايت.',
        'string' => ':attribute يجب أن يكون أكبر من :value حرف.',
        'array' => ':attribute يجب أن يحتوي على أكثر من :value من العناصر.',
    ],
    'gte' => [
        'numeric' => ':attribute يجب أن يكون أكبر من أو يساوي :value .',
        'file' => ':attribute يجب أن يكون أكبر من أو يساوي :value كيلوبايت.',
        'string' => ':attribute يجب أن يكون أكبر من أو يساوي :value حرف.',
        'array' => ':attribute يجب أن تحتوي على :value أو أكثر.',
    ],
    'image' => ':attribute يجب أن يكون ملف.',
    'in' => ':attribute المحددة غير صحيحة.',
    'in_array' => ':attribute غير متطابق مع :other .',
    'integer' => ':attribute يجب أن يكون عدد صحيح.',
    'ip' => ':attribute يجب أن يكون عنوان IP صحيحاً.',
    'ipv4' => ':attribute يجب أن يكون عنوان IPv4  صحيحاً.',
    'ipv6' => ':attribute يجب أن يكون عنوان IPv6 صحيحاً.',
    'json' => ':attribute يجب أن يكون متغير JSON صحيح.',
    'lt' => [
        'numeric' => ':attribute يجب أن يكون أقل من :value .',
        'file' => ':attribute يجب أن يكون أقل من :value كيلوبيات.',
        'string' => ':attribute يجب أن يكون أقل من :value حرف.',
        'array' => ':attribute يجب أن يحتوي على عناصر أقل من :value .',
    ],
    'lte' => [
        'numeric' => ':attribute يجب أن يكون أقل من أو يساوي :value.',
        'file' => ':attribute يجب أن يكون أقل من أو يساوي :value كيلوبايت.',
        'string' => ':attribute يجب أن يكون أقل من أو يساوي :value حرف.',
        'array' => ':attribute يجب أن لاتحتوي على عناصر أكثر من :value ',
    ],
    'max' => [
        'numeric' => ':attribute لايُمكن أن يكون أكبر من :max .',
        'file' => ':attribute لايُمكن أن يكون أكبر من :max كيلوبايت.',
        'string' => ':attribute لايُمكن أن يكون أكبر من :max حرف .',
        'array' => ':attribute لايُمكن أن يحتوي على عناصر أكثر من :max .',
    ],
    'mimes' => ':attribute يجب أن يكون ملف من النوع :values .',
    'mimetypes' => ':attribute يجب أن يكون ملف من النوع :values .',
    'min' => [
        'numeric' => ':attribute يجب أن يكون على الأقل :mins .',
        'file' => ':attribute يجب أن يكون على الأقل :mins كيلوبايت.',
        'string' => ':attribute يجب أن يكون على الأقل :mins حرف .',
        'array' => ':attribute يجب أن يحتوي على الأقل :mins عناصر.',
    ],
    'not_in' => ':attribute المحددة غير صحيحة.',
    'not_regex' => 'تنسيق :attribute غير صحيح.',
    'numeric' => ':attribute يجب أن يكون رقماً .',
    'password' => 'كلمة المرور غير صحيحة.',
    'present' => ':attribute يجب أن يحتوي على قيمة.',
    'regex' => 'تنسيق :attribute غير صحيح.',
    'required' => 'حقل :attribute مطلوب .',
    'required_if' => 'حقل :attribute مطلوب عندما يكون :other بقيمة :value.',
    'required_unless' => 'حقل :attribute مطلوب إلا إذا كان :other في :values.',
    'required_with' => 'حقل :attribute مطلوب عندما يكون :values موجوداً.',
    'required_with_all' => 'حقل :attribute مطلوب عندما يكون :values موجودين.',
    'required_without' => 'حقل :attribute مطلوب عندما يكون :values غير موجود.',
    'required_without_all' => 'حقل :attribute مطلوب عند عدم وجود أي من القيم :values .',
    'same' => 'يجب تطابق :attribute و :other.',
    'size' => [
        'numeric' => ':attribute يجب أن يكون :size .',
        'file' => ':attribute يجب أن يكون :size كيلوبايت .',
        'string' => ':attribute يجب أن يكون :size حرف.',
        'array' => 'يجب أن يحتوي :attribute على :size من العناصر.',
    ],
    'starts_with' => ':attribute يجب أن يبدأ بأحد القيم التالية : :values',
    'string' => ':attribute يجب أن يكون أحرف.',
    'timezone' => 'يجب أن يكون :attribute توقيت صحيح.',
    'unique' => ':attribute بالفعل مسجل.',
    'uploaded' => 'فشل رفع :attribute .',
    'url' => 'تنسيق :attribute غير صحيح.',
    'uuid' => 'رقم :attribute يجب أن يكون متاح.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
     */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
     */

    'attributes' => [
    ],
];
