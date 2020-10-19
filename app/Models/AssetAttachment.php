<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class AssetAttachment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'path',
        'filename',
        'asset_id'
    ];
    public $timestamps = false;

    public static function getValidationRules(){
        return [
            'path' => 'required|string',
            'filename' => 'required|string',
            'asset_id' => 'required|exists:asset,id',
        ];
    }

    public function asset(){
        return $this->belongsTo(Asset::class);
    }
}
