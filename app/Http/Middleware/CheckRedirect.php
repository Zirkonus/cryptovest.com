<?php

namespace App\Http\Middleware;

use Closure;
use App\Redirect;

class CheckRedirect
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
        $route_link = $request->server("REQUEST_URI");
        $rule = Redirect::where('old_link', $route_link)->first();
        if ($rule) {
            return redirect($rule->new_link, 301);
        }
        return $next($request);
    }
}
