@php
    /**
     * Resolve sitekey/type/theme/widget/width/colorScheme/watermark with two
     * precedence layers:
     *   1. Variables already set by the Component constructor (when invoked
     *      via <x-lazycaptcha sitekey="…" widget="newsletter" …>). The
     *      Component class normalizes inputs against package config.
     *   2. Runtime helper + config defaults — used when this view is rendered
     *      without a Component (e.g. via @lazycaptcha directive or a direct
     *      view() call).
     *
     * Newsletter widgets are pinned to type=press_hold (see Component class
     * and the backend ChallengeManager) — passing any other type is ignored.
     */
    $lcCaptcha          = $lcCaptcha          ?? app(\LazyCaptcha\Laravel\LazyCaptcha::class);
    $scriptUrl          = $scriptUrl          ?? $lcCaptcha->widgetScriptUrl();
    $sitekey            = $sitekey            ?? ($lcCaptcha->siteKey() ?? '');
    $type               = $type               ?? (config('lazycaptcha.type')   ?? 'auto');
    $theme              = $theme              ?? (config('lazycaptcha.theme')  ?? 'auto');
    $widget             = $widget             ?? (config('lazycaptcha.widget') ?? 'standard');
    $width              = $width              ?? config('lazycaptcha.width');
    $colorScheme        = $colorScheme        ?? config('lazycaptcha.color_scheme');
    $watermarkPosition  = $watermarkPosition  ?? config('lazycaptcha.watermark_position');
    $watermarkDisplay   = $watermarkDisplay   ?? config('lazycaptcha.watermark_display');

    if ($widget === 'newsletter') {
        $type = 'press_hold';
    }

    $bag = $attributes ?? new \Illuminate\View\ComponentAttributeBag([]);

    // Strip unprefixed forms (color-scheme, watermark-*) from the raw bag so
    // they don't end up as HTML attributes on the host div — the widget JS
    // only reads data-* attributes.
    if (method_exists($bag, 'except')) {
        $bag = $bag->except([
            'color-scheme', 'colorscheme',
            'watermark-position', 'watermarkposition',
            'watermark-display', 'watermarkdisplay',
        ]);
    }

    $data = array_filter([
        'data-sitekey'            => $sitekey,
        'data-type'               => $type,
        'data-theme'              => $theme,
        'data-widget'             => $widget,
        'data-width'              => $width,
        'data-color-scheme'       => $colorScheme,
        'data-watermark-position' => $watermarkPosition,
        'data-watermark-display'  => $watermarkDisplay,
    ], static fn ($value) => $value !== null && $value !== '');
@endphp

@once
    <script src="{{ $scriptUrl }}" async defer></script>
@endonce

<div {{ $bag->class('lazycaptcha')->merge($data) }}></div>
