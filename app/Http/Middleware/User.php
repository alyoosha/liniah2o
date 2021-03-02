<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;


class User
{
    public function handle($request, Closure $next)
    {
        $user = $request->cookie('user');

        if(!$user) {
            $userInfo = json_encode([
                'initialized_at' => Carbon::make(now()),
                'favorites' => [],
                'cart' => [],
                'watched' => []
            ], JSON_UNESCAPED_UNICODE);

            return $next($request)->withCookie(cookie('user', $userInfo, 43200, '/', null, null, false, false, null));
        } else {
            return $next($request);
        }
    }
}
