<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'admin_id',
        'user_id',
        'activity_date',
        'company_id',
        'activity_id',
    ];

    protected $table = 'user';
    public $timestamps = false;

    public static function getValidateResult(){
        return [
            'admin_id' => 'required|exists:user,id',
            'user_id' => 'required|exists:user,id',
            'company_id',
            'activity_id',
        ];
    }
    
    public function activity_history(){
        return $this->hasMany(ActivityHistory::class, 'activity_id');
    }
}
