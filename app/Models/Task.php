<?php

namespace App\Models;

use App\Observers\AssetObeserver;
use Illuminate\Database\Eloquent\Model;
use PDO;

class Task extends Model
{
        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'date'
    ];
    public $timestamps = false;
}
