<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Lumen\Auth\Authorizable;

class ActivityHistory extends Model implements AuthenticatableContract, AuthorizableContract
{
    use SoftDeletes;
    use Authenticatable, Authorizable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'asset_id',
        'status_id',
        'company_id',
        'start_date',
        'finish_date',
    ];

    protected $table = 'activity_history';
    public $timestamps = false;

    public static function getValidateRules(){
        return [
            'user_id' => 'required|exist:user,id',
            'asset_id' => 'required|exist:asset,id',
            'status_id' => 'required|exist:asset_status,id',
            'company_id' => 'required|exist:company,id',
            'start_date' => 'required',
            'finish_date' => 'required|after:start_date',
        ];
    }

    
}
