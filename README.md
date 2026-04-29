# LazyCaptcha for Laravel

Drop-in [LazyCaptcha](https://github.com/yourusername/lazycaptcha) integration for Laravel apps. Adds a Blade component, validation rule, middleware, and facade — so protecting a form is one line of HTML and one line of validation.

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![Latest Stable Version](https://img.shields.io/packagist/v/lazycaptcha/laravel.svg)](https://packagist.org/packages/lazycaptcha/laravel)

## Installation

```bash
composer require lazycaptcha/laravel
```

The service provider and facade auto-register via Laravel package discovery.

Publish the config (optional):

```bash
php artisan vendor:publish --tag=lazycaptcha-config
```

Add your keys to `.env`:

```ini
LAZYCAPTCHA_SITE_KEY=your-site-key-uuid
LAZYCAPTCHA_SECRET_KEY=your-secret-hex
LAZYCAPTCHA_URL=https://lazycaptcha.com
```

## Usage

### 1. Render the widget in a form

The simplest path — drop the Blade component anywhere:

```blade
<form method="POST" action="{{ route('contact.send') }}">
    @csrf

    <input type="email" name="email" required>
    <textarea name="message" required></textarea>

    <x-lazycaptcha />

    <button type="submit">Send</button>
</form>
```

The component reads the site key from your config. You can override per-form:

```blade
<x-lazycaptcha sitekey="ANOTHER_SITE_KEY" type="image_puzzle" theme="dark" />
```

Widget preset and width overrides are supported too:

```blade
<x-lazycaptcha widget="newsletter" />
<x-lazycaptcha widget="standard" width="420px" />
```

There's also a Blade directive if you prefer:

```blade
@lazycaptcha
{{-- or --}}
@lazycaptcha('SITE_KEY')
```

### 2. Verify on submit — pick one of three styles

#### Option A: Validation rule (recommended)

```php
public function store(Request $request)
{
    $validated = $request->validate([
        'email' => 'required|email',
        'message' => 'required|string|max:1000',
        'lazycaptcha-token' => 'required|lazycaptcha',
    ]);

    // ... process the validated data
}
```

For Laravel 10+ rule objects with a minimum risk score:

```php
use LazyCaptcha\Laravel\Rules\ValidLazyCaptcha;

$request->validate([
    'lazycaptcha-token' => ['required', new ValidLazyCaptcha(minScore: 0.5)],
]);
```

#### Option B: Middleware

Register the alias in `bootstrap/app.php`:

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'lazycaptcha' => \LazyCaptcha\Laravel\Http\Middleware\VerifyLazyCaptcha::class,
    ]);
})
```

Apply it to routes:

```php
Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('lazycaptcha');
```

The verification result is attached to the request:

```php
$result = $request->attributes->get('lazycaptcha');
// ['success' => true, 'score' => 0.87, 'hostname' => '...', 'challenge_ts' => '...']
```

#### Option C: Facade

```php
use LazyCaptcha;

if (! LazyCaptcha::check($request->input('lazycaptcha-token'), $request->ip())) {
    abort(422, 'Captcha failed');
}

// Or get the full response
$result = LazyCaptcha::verify($request->input('lazycaptcha-token'), $request->ip());
if (! $result['success']) {
    return back()->withErrors(['captcha' => $result['error']]);
}
```

## Configuration

Full config reference (`config/lazycaptcha.php`):

| Key | Env | Default | Description |
|-----|-----|---------|-------------|
| `site_key` | `LAZYCAPTCHA_SITE_KEY` | — | **Required.** Public site key. |
| `secret_key` | `LAZYCAPTCHA_SECRET_KEY` | — | **Required.** Secret key (server-side only). |
| `base_url` | `LAZYCAPTCHA_URL` | `https://lazycaptcha.com` | Your LazyCaptcha instance URL. |
| `timeout` | `LAZYCAPTCHA_TIMEOUT` | `5` | HTTP timeout in seconds. |
| `type` | `LAZYCAPTCHA_TYPE` | `auto` | Default challenge type. |
| `theme` | `LAZYCAPTCHA_THEME` | `auto` | Widget theme. |
| `widget` | `LAZYCAPTCHA_WIDGET` | `standard` | Widget preset. `newsletter` stays intentionally skinny. |
| `width` | `LAZYCAPTCHA_WIDTH` | â€” | Optional width override. The hosted widget caps widths at `500px`. |
| `token_field` | — | `lazycaptcha-token` | Form field name (don't change unless you know why). |
| `send_remote_ip` | — | `true` | Forward client IP to verification API. |

## Testing

When testing forms that use the captcha, you'll typically want to skip verification. Mock the facade:

```php
use LazyCaptcha\Laravel\Facades\LazyCaptcha;

LazyCaptcha::shouldReceive('check')->andReturn(true);
LazyCaptcha::shouldReceive('verify')->andReturn(['success' => true, 'score' => 1.0]);

$this->post('/contact', ['email' => 'a@b.c', 'message' => 'hi', 'lazycaptcha-token' => 'fake'])
    ->assertRedirect('/');
```

## Compatibility

- Laravel 10, 11, 12, 13
- PHP 8.2+

## License

[MIT](LICENSE)
