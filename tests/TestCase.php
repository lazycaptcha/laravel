<?php

namespace LazyCaptcha\Laravel\Tests;

use LazyCaptcha\Laravel\LazyCaptchaServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app): array
    {
        return [LazyCaptchaServiceProvider::class];
    }

    protected function getPackageAliases($app): array
    {
        return [
            'LazyCaptcha' => \LazyCaptcha\Laravel\Facades\LazyCaptcha::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('lazycaptcha.site_key', 'test-site-key');
        $app['config']->set('lazycaptcha.secret_key', 'test-secret-key');
        $app['config']->set('lazycaptcha.base_url', 'https://example.com');
    }
}
