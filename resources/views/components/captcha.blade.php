@php
    $lcCaptcha = $lcCaptcha ?? app(\LazyCaptcha\Laravel\LazyCaptcha::class);
    $scriptUrl = $scriptUrl ?? $lcCaptcha->widgetScriptUrl();
    $sitekey   = $sitekey   ?? ($lcCaptcha->siteKey() ?? '');
    $type      = $type      ?? (config('lazycaptcha.type')  ?? 'auto');
    $theme     = $theme     ?? (config('lazycaptcha.theme') ?? 'auto');
@endphp

@once
    <script src="{{ $scriptUrl }}" async defer></script>
@endonce

<div
    class="lazycaptcha"
    data-sitekey="{{ $sitekey }}"
    data-type="{{ $type }}"
    data-theme="{{ $theme }}"
    {{ $attributes ?? '' }}
></div>
