<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class controlarRutaActual
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
        $urlActual = url()->current();
        $request->session()->put('rutaActual', $urlActual);
        return $next($request);
    }
}
