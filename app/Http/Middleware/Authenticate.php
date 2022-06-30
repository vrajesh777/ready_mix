<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;

use App\Models\SiteSettingModel;
use App\Models\EmpActiveStatusModel;
use Session;
use App;
class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */

    public function handle($request, Closure $next)
    {

        $arr_site_setting = [];
        $obj_site_setting = SiteSettingModel::where('id','=','1')->first();
        if($obj_site_setting)
        {
            $arr_site_setting = $obj_site_setting->toArray();
        }

        view()->share('arr_site_setting',$arr_site_setting);

        view()->share('signed_in', \Auth::check());
        view()->share('user', \Auth::user());

        if( Session::has('locale') ) {
            App::setLocale(Session::get('locale'));
        }
        
        view()->share('locale',App::getLocale());

        $arr_login_user = [];
        $obj_user = \Auth::user();

        view()->share('obj_user',$obj_user);

        if($obj_user)
        {
            $arr_atte_data = $this->check_user_atte_status($obj_user->id ?? '');

            $arr_login_user['first_name']    = $obj_user->first_name ?? '';
            $arr_login_user['last_name']     = $obj_user->last_name ?? '';
            $arr_login_user['id']            = $obj_user->id ?? '';
            $arr_login_user['role_id']       = $obj_user->role_id ?? '';
            $arr_login_user['mobile_no']     = $obj_user->mobile_no ?? '';
            $arr_login_user['profile_image'] = $obj_user->profile_image ?? '';
            $arr_login_user['is_check_in']   = $arr_atte_data['is_check_in'] ?? '';
            $arr_login_user['date_time']     = $arr_atte_data['date_time'] ?? '';
        }
        
        view()->share('arr_login_user',$arr_login_user);

        if(!\Auth::check()) {
            return redirect()->route('login');
        }

        return $next($request);
    }

    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }

    public function check_user_atte_status($user_id)
    {
        $arr_atte_data['is_check_in'] = 0;
        $obj_status = EmpActiveStatusModel::where('date',date('Y-m-d'))
                                          ->where('user_id',$user_id)
                                          ->whereNull('end_time')
                                          ->first();
        if($obj_status)
        {
            $arr_atte_data['is_check_in'] = 1;
            $start_time                   = $obj_status->start_time ?? '';
            $date                         = isset($obj_status->date)?date('M d, Y',strtotime($obj_status->date)):'';
            $arr_atte_data['date_time']   = $date.' '.$start_time;
        }
        return $arr_atte_data;
    }
}
