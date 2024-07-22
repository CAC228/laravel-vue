<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->group && Auth::user()->group->name === 'admin') {
            return $next($request);
        }

        return redirect()->route('dashboard')->with('no_access', true);
    }
}
