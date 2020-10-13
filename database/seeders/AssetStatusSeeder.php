<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssetStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('asset_status')->count() == 0){
            DB::table('asset_status')->insert([
                [
                    'status' => 'Catat Baru',
                ],
                [
                    'status' => 'Pinjam',
                ],
                [
                    'status' => 'Idle',
                ],
                [
                    'status' => 'Rusak',
                ],
                [
                    'status' => 'Hilang',
                ],
                [
                    'status' => 'Di Service',
                ],
            ]);
        }else{
            echo "\e[31mTable is not empty, therefore NOT ";
        }
    }
}
