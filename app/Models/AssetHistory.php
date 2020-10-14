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
        'status_id',
        'company_id',
        'start_date',
        'finnish_date',
    ];

    public static function getValidationRules(){
        return [
            'user_id' => 'required|exist:user,id',
            'asset_id' => 'required|exist:asset,id',
            'status_id' => 'required|exist:status,id',
            'company_id' => 'required|exist:company,id',
            'start_date' => 'required',
            'finnish_date' => 'required|after:start_date',
        ];
    }

    protected $table = 'asset_history';
    public $timestamps = false;

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function asset(){
        return $this->belongsTo(Asset::class, 'asset_id');
    }

    public function status(){
        return $this->belongsTo(AssetStatus::class, 'status_id');
    }

    public function company(){
        return $this->belongsTo(Company::class, 'company_id');
    }
}
