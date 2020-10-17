<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
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
