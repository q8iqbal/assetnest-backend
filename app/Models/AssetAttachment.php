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

    public static function getValidateRules(){
        return [
            'path' => 'required|string',
            'filename' => 'required|string',
            'asset_id' => 'required|exists:assets,id',
        ];
    }

    public function asset(){
        return $this->belongsTo(Asset::class);
    }
}
