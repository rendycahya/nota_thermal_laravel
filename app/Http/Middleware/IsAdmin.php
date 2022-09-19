<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(!$request->session()->has('admin')){
            return redirect('/');
        }

        $response = $next($request);
        return $response->header('Cache-Control','no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
    }
}
