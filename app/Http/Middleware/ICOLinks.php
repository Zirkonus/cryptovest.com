<?php

namespace App\Http\Middleware;

use Closure;

class ICOLinks
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
    	$str = strtolower($request->path());
	    if ($str !== $request->path()) {
	    	return redirect($str);
	    }
        return $next($request);
    }
}
