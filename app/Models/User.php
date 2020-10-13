<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use SoftDeletes;
    use Authenticatable, Authorizable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id',
        'company_id',
        'name',
        'email',
        'photo',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'deleted_at',
    ];
    protected $table = 'user';
    public $timestamps = false;

    public function role(){
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function company(){
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function ownerCompany(){
        return $this->hasMany(Company::class, 'owner_id');
    }

    public function assetHistory(){
        return $this->hasMany(AssetHistory::class, 'user_id');
    }

    public function activityHistory(){
        return $this->hasMany(ActivityHistory::class, 'admin_id');
    }

    public function userActivityHistory(){
        return $this->hasMany(ActivityHistory::class, 'user_id');
    }

    public function asset(){
        return $this->hasMany(Asset::class, 'user_id');
    }

    public static function getValidationRules(){
        return [
            'name' => 'required',
            'company_id' => 'required:exist:company,id',
            'role_id' => 'required|exist:role,id',
            'email' => 'required|email',
            'password' => 'required',
            'photo' => 'mimes:jpeg, png, bmp, webp',
        ];
    }
}
