<?php

namespace Labi9\Elegan;

use Closure;
use Illuminate\Http\{
    RedirectResponse,
    Request,
    Response,
};

class ValidateAccessEleganRoutes
{
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
            return redirect()->route('access-docs', [
                'message' => config('elegan.redirect.invalid_key'),
            ]);
        }

        setcookie('elegan-key', $requestKey, $cookieExpirationTime);

        return $next($request);
    }
}
