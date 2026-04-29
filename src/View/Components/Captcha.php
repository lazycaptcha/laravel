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
    public string $widget;
    public ?string $width;
    public string $scriptUrl;

    public function __construct(
        ?string $sitekey = null,
        ?string $type = null,
        ?string $theme = null,
        ?string $widget = null,
        ?string $width = null,
    ) {
        $captcha = app(LazyCaptcha::class);
        $config = config('lazycaptcha');

        $this->sitekey = $sitekey ?: ($captcha->siteKey() ?? '');
        $this->type = $type ?: ($config['type'] ?? 'auto');
        $this->theme = $theme ?: ($config['theme'] ?? 'auto');
        $this->widget = $widget ?: ($config['widget'] ?? 'standard');
        $this->width = $width ?: ($config['width'] ?? null);
        $this->scriptUrl = $captcha->widgetScriptUrl();
    }

    public function render(): View
    {
        return view('lazycaptcha::components.captcha');
    }
}
