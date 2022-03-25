<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserRouteChecking
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    //New added route checking method to check for some pages see whether the account have the privellegd to access or not
    
    public function handle(Request $request, Closure $next)
    {
        if (!Gate::allows('isUser')) {

            return redirect('noaccess');
        }
        return $next($request);
    }
}
