<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssetTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('asset_type')->count() == 0){
            DB::table('asset_type')->insert([
                [
                    'name' => 'PC',
                    'description' => 'Sebuah pc',
                ],
                [
                    'name' => 'Aksesoris PC',
                    'description' => 'Sebuah aksesoris pc',
                ],
                [
                    'name' => 'Elektronik lain lain',
                    'description' => 'Sebuah elektronik',
                ],
                [
                    'name' => 'Mesin',
                    'description' => 'Sebuah mesin',
                ],
                [
                    'name' => 'Kendaraan',
                    'description' => 'Sebuah kendaraan',
                ],
                [
                    'name' => 'Dokumen',
                    'description' => 'Sebuah dokumen',
                ],
            ]);
        }else{
            echo "\e[31mTable is not empty, therefore NOT ";
        }
    }
}
