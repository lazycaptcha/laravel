<?php

namespace LazyCaptcha\Laravel;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Client\Factory as HttpFactory;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use LazyCaptcha\Laravel\View\Components\Captcha;

class LazyCaptchaServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/lazycaptcha.php', 'lazycaptcha');

        $this->app->singleton(LazyCaptcha::class, function (Application $app) {
            return new LazyCaptcha(
                $app->make(HttpFactory::class),
                $app['config']->get('lazycaptcha', [])
            );
        });

        $this->app->alias(LazyCaptcha::class, 'lazycaptcha');
    }

    public function boot(): void
    {
        // Publish config
        $this->publishes([
            __DIR__.'/../config/lazycaptcha.php' => config_path('lazycaptcha.php'),
        ], 'lazycaptcha-config');

        // Publish views
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/lazycaptcha'),
        ], 'lazycaptcha-views');

        // Load views (for the bundled Blade component)
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'lazycaptcha');

        // Register Blade component: <x-lazycaptcha />
        Blade::component('lazycaptcha::components.captcha', 'lazycaptcha');

        // Register validation rule: 'captcha_token' => 'required|lazycaptcha'
        Validator::extend('lazycaptcha', function ($attribute, $value, $parameters, $validator) {
            if (! is_string($value) || empty($value)) {
                return false;
            }
            $remoteIp = request()?->ip();
            return $this->app->make(LazyCaptcha::class)->check($value, $remoteIp);
        }, 'The :attribute is invalid or could not be verified.');

        // Blade directive: @lazycaptcha or @lazycaptcha('SITE_KEY')
        Blade::directive('lazycaptcha', function (string $expression) {
            $expression = trim($expression);
            if ($expression === '') {
                $expression = 'null';
            }
            return "<?php echo view('lazycaptcha::components.captcha', ['sitekey' => {$expression}])->render(); ?>";
        });
    }
}
