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

    "accepted" => "يجب الموافقة على :attribute.",
    "active_url" => ":attribute ليس رابط صحيح.",
    "after" => "يجب أن يكون :attribute تاريخاً بعد :date.",
    "after_or_equal" => "يجب أن يكون :attribute تاريخاً بعد أو يساوي :date.",
    "alpha" => " :attribute قد تحتوي على أحرف فقط.",
    "alpha_dash" => "قد تحتوي :attribute على أحرف وأرقام وشرطات فقط.",
    "alpha_num" => ":attribute قد تحتوي على أحرف وأرقام فقط.",
    "array" => "يجب أن تكون :attribute مصفوفة.",
    "before" => ":attribute يجب أن يكون تاريخاً قبل :date.",
    "before_or_equal" => ":attribute يجب أن يكون تاريخاً قبل أو نفس :date. ",
    'between' => [
        "numeric" => ":attribute يجب أن يكون بين :min و :max.",
        "file" => ":attribute يجب أن يكون بين :min و :max كيلوبايت.",
        "string" => " :attribute يجب أن يكون بين :min و :max من الأحرف.",
        "array" => ":attribute يجب أن يحتوي على عناصر بين :min و :max .",
    ],
    "boolean" => "حقل :attribute يجب أن يكون صح أو خطأ.",
    "confirmed" => "تأكيد :attribute غير متطابق .",
    "date" => "الـ:attribute ليست تاريخاً صحيحاً.",
    'date_equals' => 'The :attribute must be a date equal to :date.',
    "date_format" => ":attribute لا تتطابق مع تنسيق :format.",
    "different" => ":attribute يجب أن يكون مختلف عن :other .",
    "digits" => ":attribute يجب أن يكون :digits  رقم .",
    "digits_between" => ":attribute يجب أن يكون بين :min و :max من الأرقام",
    "dimensions" => ":attribute يحتوي على أبعاد صورة غير صالحة.",
    "distinct" => ":attribute يحتوي على قيمة مكررة.",
    "email" => ":attribute يجب أن يكون بريد إلكتروني صحيح.",
    "exists" => ":attribute المحددة غير صحيحة.",
    "file" => ":attribute يجب أن يكون ملفاً.",
    "filled" => ":attribute يجب أن يحتوي على قيمة.",
    'gt' => [
        "numeric" => ":attribute يجب أن يكون أكبر من :value.",
        "file" => ":attribute يجب أن تكون أكبر من :value كيلوبايت .",
        "string" => ":attribute يجب أن تكون أكبر من :value حرف.",
        "array" => ":attribute يجب أن يحتوي على أكثر من :value من العناصر.",
    ],
    'gte' => [
        "numeric" => ":attribute يجب أن يكون أكبر من أو يساوي :value .",
        "file" => ":attribute يجب أن يكون أكبر من أو يساوي :value كيلوبايت.",
        "string" => ":attribute يجب أن يكون أكبر من أو يساوي :value حرف.",
        "array" => ":attribute يجب أن يحتوي على :value عنصر أو أكثر.",
    ],
    "image" => ":attribute يجب أن تكون صورة.",
    "in" => ":attribute المحددة غير صحيحة.",
    "in_array" => "حقل :attribute غير موجود في :other.",
    "integer" => ":attribute يجب أن يكون عدداً صحيحاً.",
    "ip" => ":attribute يجب أن يكون عنوان IP صحيحاً.",
    "ipv4" => ":attribute يجب أن يكون عنوان IPv4  صحيحاً.",
    "ipv6" => ":attribute يجب أن يكون عنوان IPv6 صحيحاً.",
    "json" => ":attribute يجب أن يكون متغير JSON صحيح.",
    'lt' => [

        "array" => ":attribute يجب أن تحتوي على عناصر أقل من :value",
        "file" => ":attribute يجب أن تكون أقل من :value كيلوبايت",
        "numeric" => ":attribute يجب أن تكون أقل من :value ",
        "string" => ":attribute يجب أن تكون أقل من :value حرف",
    ],
    'lte' => [
        "array" => ":attribute يجب أن لا تحتوي على عناصر أكبر من :value",
        "file" => ":attribute يجب أن تكون أقل من أو تساوي :value كيلوبايت",
        "numeric" => ":attribute يجب أن تكون أقل من أو تساوي :value ",
        "string" => ":attribute يجب أن تكون أقل من أو تساوي :value حرف",
    ],
    "array" => [
        ":attribute قد لا يحتوي على أكثر من :max من العناصر.",
        "file" => ":attribute قد لا تكون أكبر من :max كيلوبايت.",
        "numeric" => ":attribute قد لا تكون أكبر من :max .",
        "string" => ":attribute قد لا تكون أكبر من :max حرف.",
    ],
    "mimes" => ":attribute يجب أن يكون ملفاً من النوع: :values.",
    "mimetypes" => ":attribute يجب أن يكون ملفاً من النوع: :values.",
    'min' => [
        "array" => ":attribute يجب أن تحتوي على الأقل على :min من العناصر.",
        "file" => ":attribute يجب أن يكون على الأقل :min كيلوبايت.",
        "numeric" => ":attribute يجب أن يكون على الأقل :min.",
        "string" => ":attribute يجب أن يكون على الأقل :min حرف.",
    ],
    "not_in" => ":attribute المحددة غير صحيحة.",
    "not_regex" => "تنسيق :attribute غير صحيح .",
    "numeric" => ":attribute يجب أن يكون رقماً .",
    "present" => ":attribute يجب أن يحتوي على قيمة.",
    "regex" => "تنسيق :attribute غير صحيح.",
    "required" => "حقل :attribute مطلوب.",
    "required_if" => "حقل :attribute مطلوب عندما يكون :other بقيمة :value.",
    "required_unless" => "حقل :attribute مطلوب إلا إذا كان :other في :values.",
    "required_with" => "حقل :attribute مطلوب عندما يكون :values موجوداً.",
    "required_with_all" => "حقل :attribute مطلوب عندما يكون :values موجوداً.",
    "required_without" => "حقل :attribute مطلوب عندما يكون :values غير موجود.",
    "required_without_all" => "حقل :attribute مطلوب عند عدم وجود أي من القيم :values .",
    "same" => ":attribute يجب أن تتطابق مع :other.",
    "size" => [
        "array" => ":attribute يجب أن يحتوي على :size من العناصر.",
        "file" => ":attribute يجب أن يكون :size كيلوبايت .",
        "numeric" => ":attribute يجب أن يكون :size .",
        "string" => ":attribute يجب أن يكون :size حرف.",
    ],
    'starts_with' => ':attribute يجب أن تبدأ بأحد القيم التالية: :values .',
    "string" => ":attribute يجب أن تكون عبارة عن متغيرات.",
    "timezone" => " :attribute يجب أن تكون منطقة صحيحة.",
    "unique" => ":attribute بالفعل مسجل.",
    "uploaded" => "فشل رفع :attribute .",
    "url" => "تنسيق :attribute غير صحيح.",
    'uuid' => ':attribute يجب أن يكون رقم UUID صحيح.',

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
