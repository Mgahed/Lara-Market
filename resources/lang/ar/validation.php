<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | following language lines contain default error messages used by
    | validator class. Some of these rules have multiple versions such
    | as size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute يجب ان تكون accepted.',
    'active_url' => ':attribute is not a valid URL.',
    'after' => ':attribute يجب ان تكون a date after :date.',
    'after_or_equal' => ':attribute يجب ان تكون a date after or equal to :date.',
    'alpha' => ':attribute must only contain letters.',
    'alpha_dash' => ':attribute must only contain letters, numbers, dashes and underscores.',
    'alpha_num' => ':attribute must only contain letters and numbers.',
    'array' => ':attribute يجب ان تكون an array.',
    'before' => ':attribute يجب ان تكون a date before :date.',
    'before_or_equal' => ':attribute يجب ان تكون a date before or equal to :date.',
    'between' => [
        'numeric' => ':attribute يجب ان تكون between :min and :max.',
        'file' => ':attribute يجب ان تكون between :min and :max kilobytes.',
        'string' => ':attribute يجب ان تكون between :min and :max characters.',
        'array' => ':attribute must have between :min and :max items.',
    ],
    'boolean' => ':attribute field يجب ان تكون true or false.',
    'confirmed' => 'تأكيد :attribute غير متطابق.',
    'date' => ':attribute is not a valid date.',
    'date_equals' => ':attribute يجب ان تكون a date equal to :date.',
    'date_format' => ':attribute does not match format :format.',
    'different' => ':attribute and :other يجب ان تكون different.',
    'digits' => ':attribute يجب ان تكون :digits digits.',
    'digits_between' => ':attribute يجب ان تكون between :min and :max digits.',
    'dimensions' => ':attribute has invalid image dimensions.',
    'distinct' => ':attribute field has a duplicate value.',
    'email' => ':attribute يجب ان تكون a valid email address.',
    'ends_with' => ':attribute must end with one of following: :values.',
    'exists' => 'selected :attribute is invalid.',
    'file' => ':attribute يجب ان تكون a file.',
    'filled' => ':attribute field must have a value.',
    'gt' => [
        'numeric' => ':attribute يجب ان تكون greater than :value.',
        'file' => ':attribute يجب ان تكون greater than :value kilobytes.',
        'string' => ':attribute يجب ان تكون greater than :value characters.',
        'array' => ':attribute must have more than :value items.',
    ],
    'gte' => [
        'numeric' => ':attribute يجب ان تكون greater than or equal :value.',
        'file' => ':attribute يجب ان تكون greater than or equal :value kilobytes.',
        'string' => ':attribute يجب ان تكون greater than or equal :value characters.',
        'array' => ':attribute must have :value items or more.',
    ],
    'image' => ':attribute يجب ان تكون an image.',
    'in' => 'selected :attribute is invalid.',
    'in_array' => ':attribute field does not exist in :other.',
    'integer' => ':attribute يجب ان تكون an integer.',
    'ip' => ':attribute يجب ان تكون a valid IP address.',
    'ipv4' => ':attribute يجب ان تكون a valid IPv4 address.',
    'ipv6' => ':attribute يجب ان تكون a valid IPv6 address.',
    'json' => ':attribute يجب ان تكون a valid JSON string.',
    'lt' => [
        'numeric' => ':attribute يجب ان تكون less than :value.',
        'file' => ':attribute يجب ان تكون less than :value kilobytes.',
        'string' => ':attribute يجب ان تكون less than :value characters.',
        'array' => ':attribute must have less than :value items.',
    ],
    'lte' => [
        'numeric' => ':attribute يجب ان تكون less than or equal :value.',
        'file' => ':attribute يجب ان تكون less than or equal :value kilobytes.',
        'string' => ':attribute يجب ان تكون less than or equal :value characters.',
        'array' => ':attribute must not have more than :value items.',
    ],
    'max' => [
        'numeric' => ':attribute must not be greater than :max.',
        'file' => ':attribute must not be greater than :max kilobytes.',
        'string' => ':attribute must not be greater than :max characters.',
        'array' => ':attribute must not have more than :max items.',
    ],
    'mimes' => ':attribute يجب ان تكون a file of type: :values.',
    'mimetypes' => ':attribute يجب ان تكون a file of type: :values.',
    'min' => [
        'numeric' => ':attribute يجب ان تكون على الاقل :min.',
        'file' => ':attribute يجب ان يكون على الاقل :min كيلوبايت.',
        'string' => ':attribute يجب ان تكون على الاقل :min احرف.',
        'array' => ':attribute يجب ان تحتوي على الاقل :min items.',
    ],
    'multiple_of' => ':attribute يجب ان تكون a multiple of :value.',
    'not_in' => 'selected :attribute is invalid.',
    'not_regex' => ':attribute format is invalid.',
    'numeric' => ':attribute يجب ان تكون a number.',
    'password' => 'password is incorrect.',
    'present' => ':attribute field يجب ان تكون present.',
    'regex' => ':attribute format is invalid.',
    'required' => ':attribute field is required.',
    'required_if' => ':attribute field is required when :other is :value.',
    'required_unless' => ':attribute field is required unless :other is in :values.',
    'required_with' => ':attribute field is required when :values is present.',
    'required_with_all' => ':attribute field is required when :values are present.',
    'required_without' => ':attribute field is required when :values is not present.',
    'required_without_all' => ':attribute field is required when none of :values are present.',
    'prohibited' => ':attribute field is prohibited.',
    'prohibited_if' => ':attribute field is prohibited when :other is :value.',
    'prohibited_unless' => ':attribute field is prohibited unless :other is in :values.',
    'same' => ':attribute and :other must match.',
    'size' => [
        'numeric' => ':attribute يجب ان تكون :size.',
        'file' => ':attribute يجب ان تكون :size kilobytes.',
        'string' => ':attribute يجب ان تكون :size characters.',
        'array' => ':attribute must contain :size items.',
    ],
    'starts_with' => ':attribute must start with one of following: :values.',
    'string' => ':attribute يجب ان تكون a string.',
    'timezone' => ':attribute يجب ان تكون a valid zone.',
    'unique' => ':attribute'.' بالفعل مسجل ',
    'uploaded' => ':attribute failed to upload.',
    'url' => ':attribute format is invalid.',
    'uuid' => ':attribute يجب ان تكون a valid UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

//    'custom' => [
//        'attribute-name' => [
//            'rule-name' => 'custom-message',
//        ],
//    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'password' => 'كلمة المرور',
        'email' => 'البريد الالكتروني'
    ],

];
