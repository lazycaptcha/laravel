@php
    /**
     * Resolve sitekey/type/theme/widget/width/scriptUrl with two precedence layers:
     *   1. Variables already set by the class-based Component constructor
     *      (when invoked via <x-lazycaptcha sitekey="…" type="…" theme="…">).
     *   2. Runtime helper + config defaults — used when this view is rendered
     *      without a Component (e.g. via the @lazycaptcha directive or a
     *      direct view() call).
     *
     * `data-sitekey`, `data-type`, `data-theme`, `data-widget`, and
     * `data-width` passed as raw HTML
     * attributes on <x-lazycaptcha> override the defaults because
     * $attributes->merge() gives precedence to the bag's existing values
     * for non-class attrs.
     */
    $lcCaptcha = $lcCaptcha ?? app(\LazyCaptcha\Laravel\LazyCaptcha::class);
    $scriptUrl = $scriptUrl ?? $lcCaptcha->widgetScriptUrl();
    $sitekey   = $sitekey   ?? ($lcCaptcha->siteKey() ?? '');
    $type      = $type      ?? (config('lazycaptcha.type')  ?? 'auto');
    $theme     = $theme     ?? (config('lazycaptcha.theme') ?? 'auto');
    $widget    = $widget    ?? (config('lazycaptcha.widget') ?? 'standard');
    $width     = $width     ?? config('lazycaptcha.width');

    $bag = $attributes ?? new \Illuminate\View\ComponentAttributeBag([]);
    $data = array_filter([
        'data-sitekey' => $sitekey,
        'data-type'    => $type,
        'data-theme'   => $theme,
        'data-widget'  => $widget,
        'data-width'   => $width,
    ], static fn ($value) => $value !== null && $value !== '');
@endphp

@once
    <script src="{{ $scriptUrl }}" async defer></script>
@endonce

<div {{ $bag->class('lazycaptcha')->merge($data) }}></div>
