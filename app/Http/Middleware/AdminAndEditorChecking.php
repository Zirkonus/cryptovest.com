<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Redirect;

class AdminAndEditorChecking
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

        if (!$currentAuthUser->isAdmin() && !$currentAuthUser->isSuperAdmin() && !$currentAuthUser->isEditor()) {

            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            }
            return redirect(Redirect::getRedirectPathAfterLoginByRole($currentAuthUser->getRole()));
        }

        return $next($request);

    }
}
