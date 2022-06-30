<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable , HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'emp_id',
        'first_name',
        'last_name',
        'email',
        'role_id',
        'department_id',
        'mobile_no',
        'report_to_id',
        'source_of_hire',
        'designation_id',
        'confirm_date',
        'join_date',
        'status',
        'emp_type',
        'profile_image',
        'address',
        'city',
        'state',
        'country_id',
        'postal_code',
        'dob',
        'marital_status',
        'gender',
        'email_token',
        'email_verified_at',
        'is_active',
        'remember_token',
        'password',
        'driving_licence',
        'id_number',
        'site_location',
        'nationality_id',
        'pay_overtime',
        'initial_trip',
        'initial_rate',
        'additional_trip',
        'additional_rate'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $guard_name = 'web';

    public function role()
    {
        return $this->belongsTo('App\Models\RolesModel','role_id','id');
    }

    public function user_meta()
    {
        return $this->hasMany('App\Models\UserMetaModel','user_id','id');
    }

    public function contact_detail()
    {
        return $this->belongsTo('App\Models\VendorContactModel','id','user_id')->select('id','vendor_id','user_id','role_position');
    }

    public function contract()
    {
        return $this->hasOne('App\Models\PurchaseContractModel','vendor_id','id');
    }

    public function sale_contracts()
    {
        return $this->hasMany('App\Models\SalesContractModel','cust_id','id');
    }

    public function cust_contact()
    {
        return $this->belongsTo('App\Models\CustomerContactModel','id','user_id')->select('id','cust_id','user_id','role_position');
    }

    public function experience()
    {
        return $this->hasMany('App\Models\EmpExperienceModel','user_id','id');
    }

    public function iqama()
    {
        return $this->hasMany('App\Models\EmpIqamaModel','user_id','id');
    }

    public function education()
    {
        return $this->hasMany('App\Models\EmpEducationModel','user_id','id');
    }

    public function designation()
    {
        return $this->hasOne('App\Models\DesignationsModel','id','designation_id');
    }

    public function transactions()
    {
        return $this->hasMany('App\Models\TransactionsModel','user_id','id');
    }

    public function department()
    {
        return $this->hasOne('App\Models\DepartmentsModel','id','department_id');
    }

    public function leaves()
    {
        return $this->hasMany('App\Models\LeaveApplicationModel','user_id','id');
    }

    public function salary_details()
    {
        return $this->belongsTo('App\Models\MasterSalaryModel','id','user_id');
    }
}
