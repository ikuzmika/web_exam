<?php

return [

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Šeit Laravel meklē Blade failus.
    | Parasti tie atrodas resources/views mapē.
    |
    */

    'paths' => [
        resource_path('views'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Compiled View Path
    |--------------------------------------------------------------------------
    |
    | Šeit Laravel glabā sakompilētos Blade failus.
    | Railway build laikā šim ceļam jābūt skaidri norādītam.
    |
    */

    'compiled' => env(
        'VIEW_COMPILED_PATH',
        storage_path('framework/views')
    ),

];
