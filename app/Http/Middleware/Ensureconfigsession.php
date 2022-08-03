<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Ensureconfigsession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $session_value = session('dbdetails');
        if (empty($session_value)) {
            return redirect('/selection');
        }
        return $next($request);
    }
}
