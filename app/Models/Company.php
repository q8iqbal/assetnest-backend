<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class Company extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'owner_id',
        'logo',
        'name',
        'address',
        'description',
        'phone',
    ];
    protected $table = 'company';
    public $timestamps = false;

    public static function getValidationRules(){
        return [
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'logo' => 'mimes:jpeg, png, bmp, webp',
        ];
    }

    public function user(){
        return $this->hasMany(User::class, 'user_id');
    }

    public function owner(){
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function asset(){
        return $this->hasMany(Asset::class, 'company_id');
    }

    public function assetHistory(){
        return $this->hasMany(AssetHistory::class, 'company_id');
    }

    public function activityHistory(){
        return $this->hasMany(ActivityHistory::class, 'company_id');
    }
}
