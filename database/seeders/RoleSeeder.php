<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('role')->count() == 0){
            DB::table('role')->insert([
                [
                    'role_name' => 'Owner',
                ],
                [
                    'role_name' => 'Admin',
                ],
                [
                    'role_name' => 'Staff',
                ],
            ]);
        }
    }
}
