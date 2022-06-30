<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Request;
use Auth;

class SalesMiddleware
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
        $loginRoleId = Auth::user()->role_id;

        $admin     = config('app.roles_id.admin');
        $sales     = config('app.roles_id.sales');

        if($loginRoleId)
        {
            view()->share('signed_in', \Auth::check());
            view()->share('user', \Auth::user());
            
            return $next($request);
        }
        /*  if(in_array($loginRoleId,[$admin,$sales]))
        {
            return $next($request);
        }
        else
        {
            abort(403);
        }*/
        /*$loginDeptId = Auth::user()->department_id;

        $admin     = config('app.dept_id.admin');
        $sales     = config('app.dept_id.sales');

        if(in_array($loginDeptId,[$admin,$sales]))
        {
            return $next($request);
        }
        else
        {
            abort(403);
        }*/
    }
}