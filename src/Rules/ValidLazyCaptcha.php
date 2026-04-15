<?php

namespace LazyCaptcha\Laravel\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use LazyCaptcha\Laravel\LazyCaptcha;

class ValidLazyCaptcha implements ValidationRule
{
    public function __construct(
        protected ?float $minScore = null,
    ) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value) || empty($value)) {
            $fail('The :attribute is required.');
            return;
        }

        $captcha = app(LazyCaptcha::class);
        $result = $captcha->verify($value, request()?->ip());

        if (! ($result['success'] ?? false)) {
            $fail('The :attribute could not be verified.');
            return;
        }

        if ($this->minScore !== null) {
            $score = (float) ($result['score'] ?? 0.0);
            if ($score < $this->minScore) {
                $fail("The :attribute risk score is too low ({$score} < {$this->minScore}).");
            }
        }
    }
}
