<?php

namespace LazyCaptcha\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static array verify(string $token, ?string $remoteIp = null)
 * @method static bool check(string $token, ?string $remoteIp = null)
 * @method static ?string siteKey()
 * @method static string widgetScriptUrl()
 * @method static string tokenField()
 *
 * @see \LazyCaptcha\Laravel\LazyCaptcha
 */
class LazyCaptcha extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \LazyCaptcha\Laravel\LazyCaptcha::class;
    }
}
