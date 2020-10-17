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
        'logo',
        'name',
        'address',
        'description',
        'phone',
    ];
    public $timestamps = false;

    public static function getValidationRules(){
        return [
            'name' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
            'logo' => 'string',
        ];
    }

    public function users(){
        return $this->hasMany(User::class);
    }

    public function asset(){
        return $this->hasMany(Asset::class);
    }
}
