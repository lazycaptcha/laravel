<?php

namespace LazyCaptcha\Laravel;

use Illuminate\Http\Client\Factory as HttpFactory;
use Illuminate\Http\Client\RequestException;

class LazyCaptcha
{
    public function __construct(
        protected HttpFactory $http,
        protected array $config,
    ) {}

    /**
     * Verify a LazyCaptcha token against the verification API.
     *
     * @return array{success: bool, score?: float, hostname?: string, challenge_ts?: string, error?: string}
     */
    public function verify(string $token, ?string $remoteIp = null): array
    {
        if (empty($token)) {
            return ['success' => false, 'error' => 'missing_token'];
        }

        $secret = $this->config['secret_key'] ?? null;
        if (empty($secret)) {
            return ['success' => false, 'error' => 'missing_secret_config'];
        }

        $payload = ['secret' => $secret, 'token' => $token];

        if ($remoteIp !== null && ($this->config['send_remote_ip'] ?? true)) {
            $payload['remote_ip'] = $remoteIp;
        }

        try {
            $response = $this->http
                ->timeout($this->config['timeout'] ?? 5)
                ->asJson()
                ->acceptJson()
                ->post(
                    rtrim($this->config['base_url'], '/') . '/api/captcha/v1/verify',
                    $payload
                );

            $body = $response->json();

            if (! is_array($body)) {
                return ['success' => false, 'error' => 'invalid_response'];
            }

            return $body;
        } catch (RequestException $e) {
            return ['success' => false, 'error' => 'request_failed', 'detail' => $e->getMessage()];
        } catch (\Throwable $e) {
            return ['success' => false, 'error' => 'unexpected_error', 'detail' => $e->getMessage()];
        }
    }

    /**
     * Convenience: returns true if verification passed.
     */
    public function check(string $token, ?string $remoteIp = null): bool
    {
        return (bool) ($this->verify($token, $remoteIp)['success'] ?? false);
    }

    public function siteKey(): ?string
    {
        return $this->config['site_key'] ?? null;
    }

    public function widgetScriptUrl(): string
    {
        return rtrim($this->config['base_url'], '/') . '/api/captcha/v1/lazycaptcha.js';
    }

    public function tokenField(): string
    {
        return $this->config['token_field'] ?? 'lazycaptcha-token';
    }
}
