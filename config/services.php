<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    'github' => [
        'client_id' => env('GH_ID'),
        'client_secret' => env('GH_SECRET'),
        'redirect' => env('APP_URL') . '/oauth/github/callback',
    ],
    'google' => [
        'client_id'     => env('GL_ID'),
        'client_secret' => env('GL_SECRET'),
        'redirect'      => env('APP_URL') . '/oauth/google/callback',
    ],
    'twitter' => [
        'client_id'     => env('TW_ID'),
        'client_secret' => env('TW_SECRET'),
        'consumer_key' => env('TW_CONSUMER_KEY'),
        'consumer_secret' => env('TW_CONSUMER_SECRET'),
        'redirect'      => env('APP_URL') . '/oauth/twitter/callback',
    ],
    'facebook' => [
        'client_id' => env('FB_ID'),
        'client_secret' => env('FB_SECRET'),
        'redirect' => env('APP_URL') . '/oauth/facebook/callback',
    ]

];
