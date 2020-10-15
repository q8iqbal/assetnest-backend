<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('asset')->insert([
            'user_id' => 1,
            'type_id' => 1,
            'status_id' => 1,
            'company_id' => 1,
            'product_code' => 'JHVEB',
            'name' => 'leptop',
            'location' => 'ngarep omah',
            'price' => 'mahal pake bgt',
            'note' => 'ini bukan catatan'
        ]);

        DB::table('asset')->insert([
            'user_id' => 3,
            'type_id' => 3,
            'status_id' => 3,
            'company_id' => 1,
            'product_code' => 'JHVEBNKJ',
            'name' => 'kunai',
            'location' => 'ngarep omah',
            'price' => 'mahal pake bgt',
            'note' => 'ini bukan catatan'
        ]);

        DB::table('asset')->insert([
            'user_id' => 2,
            'type_id' => 2,
            'status_id' => 2,
            'company_id' => 2,
            'product_code' => 'JHKJVEB',
            'name' => 'suriken',
            'location' => 'ngarep omah',
            'price' => 'mahal pake bgt',
            'note' => 'ini bukan catatan'
        ]);

        DB::table('asset')->insert([
            'user_id' => 4,
            'type_id' => 4,
            'status_id' => 1,
            'company_id' => 2,
            'product_code' => 'JKNHKJVEB',
            'name' => 'scroll',
            'location' => 'ngarep omah',
            'price' => 'mahal pake bgt',
            'note' => 'ini bukan catatan'
        ]);

        DB::table('asset')->insert([
            'user_id' => 5,
            'type_id' => 4,
            'status_id' => 1,
            'company_id' => 2,
            'product_code' => 'JKKJVEB',
            'name' => 'tay',
            'location' => 'ngarep omah',
            'price' => 'mahal pake bgt',
            'note' => 'ini bukan catatan' 
        ]);
    }
}
