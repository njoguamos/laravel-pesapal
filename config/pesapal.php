<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Pesapal Live Mode
    |--------------------------------------------------------------------------
    |
    | Determine is your application is running live or testing mode. The
    | sandbox environment is used for testing API integration without
    | moving any money. The live environment means your application
    | is live using Pesapal for the production.
    |
    |
    */

    'pesapal_live' => env(key: 'PESAPAL_LIVE', default: false),


    /*
    |--------------------------------------------------------------------------
    | Base Endpoint Configuration
    |--------------------------------------------------------------------------
    |
    | This configuration option determines the base URL for the Pesapal API.
    | The base URL is determined by the current environment of your
    | application.
    |
    */

    'base_url' => [
        'live'    => 'https://pay.pesapal.com/v3',
        'staging' => 'https://cybqa.pesapal.com/pesapalv3',
    ],

    /*
   |--------------------------------------------------------------------------
   | Payment Redirect URL
   |--------------------------------------------------------------------------
   |
   | This is the URL that you can use with order tracking ID to redirect the
   | user to the payment page. It is important when you need to retry payment
   | after the payment had failed.
   |
   */
    "redirect_url" => [
        "live"    => "https://pay.pesapal.com/iframe/PesapalIframe3/Index",
        "staging" => "https://cybqa.pesapal.com/pesapaliframe/PesapalIframe3/Index"
    ],


    /*
    |--------------------------------------------------------------------------
    | Pesapal Consumer Key
    |--------------------------------------------------------------------------
    |
    | The Consumer Key is a unique identifier for your application and is used
    | to authenticate your application with the Pesapal API. This key is
    | provided by Pesapal when you register your application.
    |
    */
    'consumer_key' => env(key: 'PESAPAL_CONSUMER_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Pesapal Consumer Secret
    |--------------------------------------------------------------------------
    |
    | The Consumer Secret is a secret known only to your application and the
    | Pesapal API. It is used in combination with the Consumer Key to
    | authenticate your application with the Pesapal API. This secret
    | is provided by Pesapal when you register your application.
    |
    */
    'consumer_secret' => env(key: 'PESAPAL_CONSUMER_SECRET'),

];
