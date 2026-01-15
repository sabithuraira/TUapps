<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckKdkab
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $kdkab
     * @return mixed
     */
    public function handle($request, Closure $next, $kdkab = '00')
    {
        if (!Auth::check()) {
            abort(403, 'Unauthorized access.');
        }

        if (Auth::user()->kdkab != $kdkab) {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}

