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
    public ?string $colorScheme;
    public ?string $watermarkPosition;
    public ?string $watermarkDisplay;
    public string $scriptUrl;

    /**
     * Component props mirror the data-* attributes the widget JS reads from
     * the host element. Passing them through the Component class (instead of
     * the loose attribute bag) lets us:
     *   - normalize them server-side
     *   - fall back to package config defaults
     *   - keep them out of the raw HTML attribute bag (so they don't leak as
     *     unprefixed attributes that the widget JS won't read)
     */
    public function __construct(
        ?string $sitekey = null,
        ?string $type = null,
        ?string $theme = null,
        ?string $widget = null,
        ?string $width = null,
        ?string $colorScheme = null,
        ?string $watermarkPosition = null,
        ?string $watermarkDisplay = null,
    ) {
        $captcha = app(LazyCaptcha::class);
        $config = config('lazycaptcha');

        $this->sitekey           = $sitekey ?: ($captcha->siteKey() ?? '');
        $this->type              = $type    ?: ($config['type']   ?? 'auto');
        $this->theme             = $theme   ?: ($config['theme']  ?? 'auto');
        $this->widget            = $widget  ?: ($config['widget'] ?? 'standard');
        $this->width             = $width   ?: ($config['width']  ?? null);
        $this->colorScheme       = $colorScheme       ?: ($config['color_scheme']        ?? null);
        $this->watermarkPosition = $watermarkPosition ?: ($config['watermark_position']  ?? null);
        $this->watermarkDisplay  = $watermarkDisplay  ?: ($config['watermark_display']   ?? null);

        // Newsletter is intentionally minimal — server-side enforce press_hold
        // even if the caller passed something else. The backend also enforces
        // this in ChallengeManager, but pre-baking it into the data-type lets
        // the widget skip the auto-route round-trip.
        if ($this->widget === 'newsletter') {
            $this->type = 'press_hold';
        }

        $this->scriptUrl = $captcha->widgetScriptUrl();
    }

    public function render(): View
    {
        return view('lazycaptcha::components.captcha');
    }
}
