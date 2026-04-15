<?php

namespace LazyCaptcha\Laravel\Tests\Unit;

use Illuminate\Support\Facades\Http;
use LazyCaptcha\Laravel\LazyCaptcha;
use LazyCaptcha\Laravel\Tests\TestCase;

class LazyCaptchaTest extends TestCase
{
    public function test_verify_returns_failure_for_empty_token(): void
    {
        $result = $this->app->make(LazyCaptcha::class)->verify('');
        $this->assertFalse($result['success']);
        $this->assertSame('missing_token', $result['error']);
    }

    public function test_verify_calls_correct_endpoint_and_returns_response(): void
    {
        Http::fake([
            'example.com/api/captcha/v1/verify' => Http::response([
                'success' => true,
                'score' => 0.87,
                'hostname' => 'example.org',
                'challenge_ts' => '2026-04-15T12:00:00+00:00',
            ], 200),
        ]);

        $result = $this->app->make(LazyCaptcha::class)->verify('valid-token', '1.2.3.4');

        $this->assertTrue($result['success']);
        $this->assertSame(0.87, $result['score']);

        Http::assertSent(function ($request) {
            return $request->url() === 'https://example.com/api/captcha/v1/verify'
                && $request['secret'] === 'test-secret-key'
                && $request['token'] === 'valid-token'
                && $request['remote_ip'] === '1.2.3.4';
        });
    }

    public function test_check_returns_boolean(): void
    {
        Http::fake([
            'example.com/*' => Http::response(['success' => true], 200),
        ]);

        $this->assertTrue($this->app->make(LazyCaptcha::class)->check('any-token'));
    }

    public function test_widget_script_url_is_built_from_base_url(): void
    {
        $url = $this->app->make(LazyCaptcha::class)->widgetScriptUrl();
        $this->assertSame('https://example.com/api/captcha/v1/lazycaptcha.js', $url);
    }

    public function test_validation_rule_passes_on_successful_verify(): void
    {
        Http::fake([
            'example.com/*' => Http::response(['success' => true, 'score' => 0.9], 200),
        ]);

        $validator = validator(
            ['captcha' => 'good-token'],
            ['captcha' => 'lazycaptcha']
        );

        $this->assertTrue($validator->passes());
    }

    public function test_validation_rule_fails_on_failed_verify(): void
    {
        Http::fake([
            'example.com/*' => Http::response(['success' => false, 'error' => 'invalid_token'], 200),
        ]);

        $validator = validator(
            ['captcha' => 'bad-token'],
            ['captcha' => 'lazycaptcha']
        );

        $this->assertFalse($validator->passes());
    }
}
