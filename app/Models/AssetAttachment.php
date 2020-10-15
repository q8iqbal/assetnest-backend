<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class AssetAttachment extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'attachment',
        'asset_id'
    ];
    protected $table = 'asset_attachment';
    public $timestamps = false;

    public static function getValidateRules(){
        return [
            'attachment' => 'string',
            'asset_id' => 'exists:asset,id',
        ];
    }

    public function asset(){
        return $this->belongsTo(Asset::class, 'asset_id');
    }
}
