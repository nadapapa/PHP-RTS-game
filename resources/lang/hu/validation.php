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

    'accepted'             => ':attribute : ezt el kell fogadjad.',
    'active_url'           => ':attribute nem érvényes URL.',
    'after'                => ':attribute későbbi kell legyen, mint :date.',
    'alpha'                => ':attribute csak betűket tartalmazhat.',
    'alpha_dash'           => ':attribute csak betűket, számokat és _-t tartalmazhat.',
    'alpha_num'            => ':attribute csak betűket és számokat tartalmazhat.',
    'array'                => ':attribute tömb kell legyen.',
    'before'               => ':attribute korábbi kell legyen, mint :date.',
    'between'              => [
        'numeric' => ':attribute :min és :max között kell legyen.',
        'file'    => ':attribute :min és :max kilobyte között kell legyen.',
        'string'  => ':attribute :min és :max karakter között kell legyen.',
        'array'   => ':attribute :min és :max elem között kell legyen.',
    ],
    'boolean'              => ':attribute mező csak igaz vagy hamis lehet.',
    'confirmed'            => ':attribute és megerősítése nem egyezik.',
    'date'                 => ':attribute nem érvényes dátum.',
    'date_format'          => ':attribute nem egyezik a formátummal: :format.',
    'different'            => ':attribute és :other különböző kell legyen.',
    'digits'               => ':attribute :digits számjegy hosszú kell legyen.',
    'digits_between'       => ':attribute :min és :max számjegy hosszúság között kell legyen .',
    'email'                => ':attribute valós email cím kell legyen.',
    'exists'               => 'A kiválasztott :attribute érvénytelen.',
    'filled'               => ':attribute szükséges.',
    'image'                => ':attribute egy kép kell legyen.',
    'in'                   => 'A kiválasztott :attribute érvénytelen.',
    'integer'              => ':attribute egy egész szám kell legyen.',
    'ip'                   => ':attribute érvényes IP cím kell legyen.',
    'json'                 => ':attribute érvényes JSON sztring kell legyen.',
    'max'                  => [
        'numeric' => ':attribute nem lehet nagyobb, mint :max.',
        'file'    => ':attribute nem lehet nagyobb, mint :max kilobyte.',
        'string'  => ':attribute nem lehet nagyobb, mint :max karakter.',
        'array'   => ':attribute nem állhat több elemből, mint :max.',
    ],
    'mimes'                => ':attribute :values fájltípus kell legyen.',
    'min'                  => [
        'numeric' => ':attribute legalább :min kell legyen.',
        'file'    => ':attribute legalább :min kilobyte kell legyen.',
        'string'  => ':attribute legalább :min karakter kell legyen.',
        'array'   => ':attribute legalább :min elemből kell álljon.',
    ],
    'not_in'               => 'A kiválasztott :attribute érvénytelen.',
    'numeric'              => ':attribute egy szám kell legyen.',
    'regex'                => ':attribute formátuma érvénytelen.',
    'required'             => ':attribute mező szükséges.',
    'required_if'          => ':attribute mező szükséges, ha :other :value.',
    'required_with'        => ':attribute mező szükséges, ha :values is vannnak.',
    'required_with_all'    => ':attribute mező szükséges, ha :values is vannak.',
    'required_without'     => ':attribute mező szükséges, ha :values nincsenek.',
    'required_without_all' => ':attribute mező szükséges, ha :values közül egyik sincs jelen.',
    'same'                 => ':attribute és :other meg kell egyezzen.',
    'size'                 => [
        'numeric' => ':attribute mérete :size kell legyen.',
        'file'    => ':attribute mérete :size kilobyte kell legyen.',
        'string'  => ':attribute mérete :size karakter kell legyen.',
        'array'   => ':attribute :size elemet kell tartalmazzon.',
    ],
    'string'               => ':attribute sztring kell elgyen.',
    'timezone'             => ':attribute érvényes zóna kell legyen.',
    'unique'               => ':attribute már foglalt.',
    'url'                  => ':attribute formátuma érvénytelen.',

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
//        'password' => [
//            'required' => 'A jelszó mező kitöltése szükséges',
//        ],
//        'email' => [
//            'required' => 'Az email mező kitöltése szükséges',
//        ],
//        'name' => [
//            'required' => 'A név mező kitöltése szükséges',
//        ],
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
        'password' => 'A jelszó',
        'email' => 'Az e-mail',
        'name' => 'A név',
        'nation' => 'A nép',
    ],

];
