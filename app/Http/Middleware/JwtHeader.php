<?php

namespace App\Http\Middleware;

use Closure;

class jwtheader
{
    public function handle($request, Closure $next)
    {
        $jwt = session()->get('jwt');
        if ($jwt) {
            $request->headers->set('Authorization', 'Bearer ' . $jwt);
        }

        return $next($request);
    }
}
