<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Redirect;

class CheckRole
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
        $currentAuthUser = Auth::user();

        if (!$currentAuthUser) {
            return redirect('login');
        }

        $chapterAvailableForRole = (array_filter(func_get_args(), function($k) {
            return $k > 1;
        }, ARRAY_FILTER_USE_KEY));


        if (!in_array($currentAuthUser->getRole(), $chapterAvailableForRole)) {

            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            }
            return redirect(Redirect::getRedirectPathAfterLoginByRole($currentAuthUser->getRole()));
        }

        return $next($request);

    }
}
