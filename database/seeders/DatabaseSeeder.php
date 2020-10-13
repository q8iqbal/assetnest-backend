<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call('UsersTableSeeder');
        $this->call(RoleSeeder::class);
        $this->call(ActivitySeeder::class);
        $this->call(AssetStatusSeeder::class);
        $this->call(AssetTypeSeeder::class);
    }
}
