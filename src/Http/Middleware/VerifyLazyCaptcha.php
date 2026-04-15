<?php

namespace LazyCaptcha\Laravel\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use LazyCaptcha\Laravel\LazyCaptcha;
use Symfony\Component\HttpFoundation\Response;

class VerifyLazyCaptcha
{
    public function __construct(
        protected LazyCaptcha $captcha,
    ) {}

    public function handle(Request $request, Closure $next, ?string $field = null): Response
    {
        $field = $field ?: $this->captcha->tokenField();
        $token = $request->input($field);

        $result = $this->captcha->verify(
            (string) $token,
            $request->ip()
        );

        if (! ($result['success'] ?? false)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Captcha verification failed.',
                    'error' => $result['error'] ?? 'verification_failed',
                ], 422);
            }

            return back()
                ->withInput($request->except($field))
                ->withErrors([$field => 'Captcha verification failed. Please try again.']);
        }

        // Attach the verification result for downstream consumers
        $request->attributes->set('lazycaptcha', $result);

        return $next($request);
    }
}
