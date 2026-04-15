<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Site Key (public)
    |--------------------------------------------------------------------------
    |
    | The public site key embedded in the widget. Visible to end users.
    |
    */
    'site_key' => env('LAZYCAPTCHA_SITE_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Secret Key (private)
    |--------------------------------------------------------------------------
    |
    | The private secret key used for server-side verification.
    | NEVER expose this in client-side code.
    |
    */
    'secret_key' => env('LAZYCAPTCHA_SECRET_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Base URL
    |--------------------------------------------------------------------------
    |
    | The URL of your LazyCaptcha instance. For self-hosted setups, point
    | this at your installation. The default points at lazycaptcha.com.
    |
    */
    'base_url' => env('LAZYCAPTCHA_URL', 'https://lazycaptcha.com'),

    /*
    |--------------------------------------------------------------------------
    | HTTP Timeout
    |--------------------------------------------------------------------------
    |
    | Maximum seconds to wait for the verification API.
    |
    */
    'timeout' => (int) env('LAZYCAPTCHA_TIMEOUT', 5),

    /*
    |--------------------------------------------------------------------------
    | Default Challenge Type
    |--------------------------------------------------------------------------
    |
    | The challenge type rendered by default. One of:
    | 'auto', 'image_puzzle', 'pow', 'behavioral', 'text_math'.
    |
    */
    'type' => env('LAZYCAPTCHA_TYPE', 'auto'),

    /*
    |--------------------------------------------------------------------------
    | Theme
    |--------------------------------------------------------------------------
    |
    | Default widget theme. 'light' or 'dark'.
    |
    */
    'theme' => env('LAZYCAPTCHA_THEME', 'light'),

    /*
    |--------------------------------------------------------------------------
    | Token Field Name
    |--------------------------------------------------------------------------
    |
    | The form field name the widget injects after solving. Don't change this
    | unless you have a specific reason — the widget hardcodes this name.
    |
    */
    'token_field' => 'lazycaptcha-token',

    /*
    |--------------------------------------------------------------------------
    | Send Remote IP
    |--------------------------------------------------------------------------
    |
    | Whether to forward the client IP to the verification API for additional
    | risk scoring.
    |
    */
    'send_remote_ip' => true,

];
