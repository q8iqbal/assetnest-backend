<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class AssetHistory extends Model
{
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
            'user_id' => 'required|exists:users,id',
            'asset_id' => 'required|exists:assets,id',
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
