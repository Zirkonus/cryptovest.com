<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Redirect;

class AdminChecking
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
	    if (Auth::user()) {
	        $userRole = Auth::user()->is_admin;
	        if(Auth::user()->is_admin != 1 and Auth::user()->is_admin != 2) {
			    if ($request->ajax() || $request->wantsJson()) {
				    return response('Unauthorized.', 401);
			    } else {
				   return redirect(Redirect::getRedirectPathAfterLoginByRole($userRole));
			    }
		    }
		    return $next($request);
	    } else {
	    	return redirect('login');
	    }
    }
}
