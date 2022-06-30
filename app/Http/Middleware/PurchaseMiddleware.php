<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Auth;

class PurchaseMiddleware
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
        $purchase  = config('app.roles_id.purchase');

        if($loginRoleId)
        {
            view()->share('signed_in', \Auth::check());
            view()->share('user', \Auth::user());
            
            return $next($request);
        }
       /* if(in_array($loginRoleId,[$admin,$purchase]))
        {
            view()->share('signed_in', \Auth::check());
            view()->share('user', \Auth::user());
            
            return $next($request);
        }
        else
        {
            abort(403);
        }*/

       
    }
}
