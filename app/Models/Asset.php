<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
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

    public static function getValidationRules(){
        return [
            'type' => 'required|string',
            'company_id' => 'required|exists:companies,id',
            'photo' => 'string',
            'code' => 'required|string',
            'name' => 'required|string',
            'price' => 'required',
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
