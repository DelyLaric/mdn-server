<?php

namespace App\Http\Middleware;

use Closure;
use JWT;

class Auth
{
    public function handle($request, Closure $next)
    {
        return $next($request);
    }
}
