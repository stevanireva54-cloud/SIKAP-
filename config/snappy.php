<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Snappy PDF / Image Configuration
    |--------------------------------------------------------------------------
    |
    | Konfigurasi wkhtmltopdf dan wkhtmltoimage untuk Windows.
    |
    */

    'pdf' => [
        'enabled' => true,

        'binary' => env(
            'WKHTML_PDF_BINARY',
            'C:\Program Files\wkhtmltopdf\bin\wkhtmltopdf.exe'
        ),

        'timeout' => false,

        'options' => [
            'enable-local-file-access' => true,
            'encoding' => 'UTF-8',
            'page-size' => 'A4',
            'margin-top' => 10,
            'margin-right' => 10,
            'margin-bottom' => 10,
            'margin-left' => 10,
            'print-media-type' => true,
        ],

        'env' => [],
    ],

    'image' => [
        'enabled' => true,

        'binary' => env(
            'WKHTML_IMG_BINARY',
            'C:\Program Files\wkhtmltopdf\bin\wkhtmltoimage.exe'
        ),

        'timeout' => false,

        'options' => [
            'enable-local-file-access' => true,
            'encoding' => 'UTF-8',
        ],

        'env' => [],
    ],

];