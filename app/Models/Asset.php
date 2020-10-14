<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class Asset extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'type_id',
        'status_id',
        'company_id',
        'photo',
        'product_code',
        'name',
        'purchase_date',
        'price',
        'start_date',
        'location',
        'note',
    ];

    protected $table = 'asset';
    public $timestamps = false;

    public static function getValidateRules(){
        return [
            'user_id' => 'required|exists:user,id',
            'type_id' => 'required|exists:asset_type,id',
            'status_id' => 'required|exists:asset_status,id',
            'company_id' => 'required|exists:company,id',
            'photo' => 'file',
            'product_code' => 'required',
            'name' => 'required',
            'purchase_date' => 'required',
            'start_date'=> 'required',
        ];
    }

    public function assetHistory(){
        return $this->hasMany('asset_history', 'asset id');
    }

    public function assetStatus(){
        return $this->belongsTo('asset_status', 'status_id');
    }

    public function assetType(){
        return $this->belongsTo('asset_type', 'type_id');
    }

    public function company(){
        return $this->belongsTo('company', 'company_id');
    }

    public function user(){
        return $this->belongsTo('user', 'user_id');
    }
}
