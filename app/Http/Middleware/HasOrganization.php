<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Laracasts\Flash\Flash;

class HasOrganization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $organization = $request->user()->organization()->first();

        if ($organization == null) {
            Flash::error(Lang::get('organization.fail-not-exist'));
            return redirect(action('OrganizationController@create'));
        } else {
            return $next($request);
        }

    }
}
