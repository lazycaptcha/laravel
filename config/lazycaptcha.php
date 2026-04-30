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
    | 'auto', 'image_puzzle', 'pow', 'behavioral', 'text_math', 'press_hold', 'rotate_align'.
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
    'theme' => env('LAZYCAPTCHA_THEME', 'auto'),

    /*
    |--------------------------------------------------------------------------
    | Widget Preset
    |--------------------------------------------------------------------------
    |
    | Default widget preset. One of: 'standard', 'compact', 'newsletter',
    | or 'login'. Newsletter stays intentionally skinny.
    |
    */
    'widget' => env('LAZYCAPTCHA_WIDGET', 'standard'),

    /*
    |--------------------------------------------------------------------------
    | Width Override
    |--------------------------------------------------------------------------
    |
    | Optional widget width override. The hosted widget caps widths at 500px.
    | Leave null to use the preset's natural width (which is now compact by
    | default — 280px standard, 240px compact, 260px login, 220px newsletter).
    |
    */
    'width' => env('LAZYCAPTCHA_WIDTH'),

    /*
    |--------------------------------------------------------------------------
    | Color Scheme
    |--------------------------------------------------------------------------
    |
    | Default color scheme for the widget accent. One of:
    | 'default' (purple), 'ocean', 'forest', 'sunset', 'graphite'.
    | Leave null/unset to use the widget's default scheme.
    |
    */
    'color_scheme' => env('LAZYCAPTCHA_COLOR_SCHEME'),

    /*
    |--------------------------------------------------------------------------
    | Watermark Position
    |--------------------------------------------------------------------------
    |
    | Where the LazyCaptcha branding appears. One of:
    | 'footer-right' (default), 'footer-left', 'top-right', 'top-left'.
    | Newsletter widgets always render the watermark in the top-right.
    |
    */
    'watermark_position' => env('LAZYCAPTCHA_WATERMARK_POSITION'),

    /*
    |--------------------------------------------------------------------------
    | Watermark Display
    |--------------------------------------------------------------------------
    |
    | How prominent the watermark is. One of: 'full', 'badge', 'icon'.
    | Available on paid plans — free plans always render 'full'.
    |
    */
    'watermark_display' => env('LAZYCAPTCHA_WATERMARK_DISPLAY'),

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
