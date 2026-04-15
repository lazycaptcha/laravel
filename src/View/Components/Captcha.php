<?php

namespace LazyCaptcha\Laravel\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use LazyCaptcha\Laravel\LazyCaptcha;

class Captcha extends Component
{
    public string $sitekey;
    public string $type;
    public string $theme;
    public string $scriptUrl;

    public function __construct(
        ?string $sitekey = null,
        ?string $type = null,
        ?string $theme = null,
    ) {
        $captcha = app(LazyCaptcha::class);
        $config = config('lazycaptcha');

        $this->sitekey = $sitekey ?: ($captcha->siteKey() ?? '');
        $this->type = $type ?: ($config['type'] ?? 'auto');
        $this->theme = $theme ?: ($config['theme'] ?? 'light');
        $this->scriptUrl = $captcha->widgetScriptUrl();
    }

    public function render(): View
    {
        return view('lazycaptcha::components.captcha');
    }
}
