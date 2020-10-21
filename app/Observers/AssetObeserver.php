<?php
namespace App\Observers;

use Illuminate\Support\Facades\Log;

trait AssetObeserver{
    protected static function boot(){
        parent::boot();
        static::updated(function ($post){
            Log::info('upgrade people, updgrade', [$post]);
        });
    }
}