<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class AssetHistory extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'asset_id',
        'status',
        'date',
    ];

    public static function getValidationRules(){
        return [
            'user_id' => 'required|exists:user,id',
            'asset_id' => 'required|exists:asset,id',
            'status' => 'required',
        ];
    }

    public $timestamps = false;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function asset(){
        return $this->belongsTo(Asset::class);
    }
}
