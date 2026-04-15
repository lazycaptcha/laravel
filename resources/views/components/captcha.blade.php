@once
    <script src="{{ $scriptUrl }}" async defer></script>
@endonce

<div
    class="lazycaptcha"
    data-sitekey="{{ $sitekey }}"
    data-type="{{ $type }}"
    data-theme="{{ $theme }}"
    {{ $attributes }}
></div>
