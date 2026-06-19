<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'pay0shop' => [
        'token' => env('PAY0SHOP_TOKEN'),
        'secret_key' => env('PAY0SHOP_SECRET_KEY'),
        'callback_url' => env('PAY0SHOP_CALLBACK_URL'),
    ],

    'payment' => [
        'default_gateway' => env('PAYMENT_GATEWAY', 'pay0shop'),
    ],

    'serdihin' => [
        'api_key' => env('SERDIHIN_PAY_API_KEY'),
        'api_secret' => env('SERDIHIN_PAY_API_SECRET'),
        'webhook_secret' => env('SERDIHIN_PAY_WEBHOOK_SECRET'),
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URI'),
    ],

];
