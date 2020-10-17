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
        'type',
        'company_id',
        'photo',
        'code',
        'name',
        'purchase_date',
        'price',
        'location',
        'note',
    ];
    public $timestamps = false;

    public static function getValidateRules(){
        return [
            'type' => 'required|string',
            'company_id' => 'required|exists:company,id',
            'photo' => 'string',
            'product_code' => 'required|string',
            'name' => 'required|string',
            'purchase_date' => 'required',
        ];
    }

    public function assetHistory(){
        return $this->hasMany(AssetHistory::class);
    }

    public function assetAttachment(){
        return $this->hasMany(AssetAttachment::class);
    }

    public function company(){
        return $this->belongsTo(Company::class);
    }
}
