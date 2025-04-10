<?php

namespace Jcsfran\Elegan;

use Closure;
use Illuminate\Http\{
    RedirectResponse,
    Request,
    Response,
};
use Illuminate\Support\Facades\RateLimiter;

class ValidateAccessEleganRoutes
{
    private function checkRequestLimit(string | null $key)
    {
        $hasLimit = RateLimiter::attempt(
            $key,
            config('elegan.rate_limit'),
            function () {},
            config('elegan.decay_minutes') * 60,
        );

        if (!$hasLimit) {
            return redirect()->route('access-docs', [
                'message' => 'aaaaa',
            ]);
        }
    }

    public function handle(Request $request, Closure $next): RedirectResponse|Response
    {
        $requestKey = $request->input('key');
        $eleganKey = config('elegan.key');
        $minutes = 10;
        $seconds = 60;
        $cookieExpirationTime = time() + $seconds * $minutes;
        $cookie = '';

        if (isset($_COOKIE['elegan-key'])) {
            $cookie = $_COOKIE['elegan-key'];
        }

        if ($cookie !== $eleganKey && !$requestKey) {
            return redirect()->route('access-docs', [
                'message' => config('elegan.redirect.expire'),
            ]);
        }

        if ((!empty($cookie) && $cookie !== $eleganKey) || ($requestKey !== $eleganKey)) {
            $this->checkRequestLimit($request->ip());

            return redirect()->route('access-docs', [
                'message' => config('elegan.redirect.invalid_key'),
            ]);
        }

        setcookie('elegan-key', $requestKey, $cookieExpirationTime);

        return $next($request);
    }
}
