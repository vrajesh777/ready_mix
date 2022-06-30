<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Auth;

class DeliveryMiddleware
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
        $loginRoleId = Auth::user()->role_id;

        $admin     = config('app.roles_id.admin');
        $delivery  = config('app.roles_id.delivery');

        if($loginRoleId)
        {
            view()->share('signed_in', \Auth::check());
            view()->share('user', \Auth::user());
            
            return $next($request);
        }

        /*if(in_array($loginRoleId,[$admin,$delivery]))
        {
            return $next($request);
        }
        else
        {
            abort(403);
        }*/
    }
}
