<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('company')->insert([
            'owner_id' => 1,
            'name' => 'pabrik sepatu',
            'address' => 'jalan jalan',
            'phone' => '98209413920'
        ]);

        DB::table('company')->insert([
            'owner_id' => 2,
            'name' => 'pabrik kayu',
            'address' => 'jalan cuk',
            'phone' => '982094102023'
        ]);
    }
}
