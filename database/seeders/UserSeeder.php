<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user')->insert([
            'role_id' => 1,
            'company_id' => 1,
            'name' => 'uchiha',
            'email' => 'email@mail.com',
            'password' => 'ejhsdbf'
        ]);

        DB::table('user')->insert([
            'role_id' => 2,
            'company_id' => 1,
            'name' => 'uchiha admin',
            'email' => 'email@mail.com',
            'password' => 'ejhsdbf'
        ]);

        DB::table('user')->insert([
            'role_id' => 2,
            'company_id' => 1,
            'name' => 'uchiha admin 2',
            'email' => 'email@mail.com',
            'password' => 'ejhsdbf'
        ]);

        DB::table('user')->insert([
            'role_id' => 3,
            'company_id' => 1,
            'name' => 'uchiha staff 1',
            'email' => 'email@mail.com',
            'password' => 'ejhsdbf'
        ]);

        DB::table('user')->insert([
            'role_id' => 3,
            'company_id' => 1,
            'name' => 'uchiha staff 2',
            'email' => 'email@mail.com',
            'password' => 'ejhsdbf'
        ]);

        DB::table('user')->insert([
            'role_id' => 3,
            'company_id' => 1,
            'name' => 'uchiha staff 3',
            'email' => 'email@mail.com',
            'password' => 'ejhsdbf'
        ]);

        DB::table('user')->insert([
            'role_id' => 1,
            'company_id' => 2,
            'name' => 'uzumaki sasuke',
            'email' => 'email@mail.com',
            'password' => 'ejhsdbf'
        ]);

        DB::table('user')->insert([
            'role_id' => 2,
            'company_id' => 2,
            'name' => 'uzumaki admin 1',
            'email' => 'email@mail.com',
            'password' => 'ejhsdbf'
        ]);

        DB::table('user')->insert([
            'role_id' => 2,
            'company_id' => 2,
            'name' => 'uzumaki admin 2',
            'email' => 'email@mail.com',
            'password' => 'ejhsdbf'
        ]);

        DB::table('user')->insert([
            'role_id' => 3,
            'company_id' => 2,
            'name' => 'uzumaki staff 1',
            'email' => 'email@mail.com',
            'password' => 'ejhsdbf'
        ]);

        DB::table('user')->insert([
            'role_id' => 3,
            'company_id' => 2,
            'name' => 'uzumaki staff 2',
            'email' => 'email@mail.com',
            'password' => 'ejhsdbf'
        ]);

        DB::table('user')->insert([
            'role_id' => 3,
            'company_id' => 2,
            'name' => 'uzumaki staff 3',
            'email' => 'email@mail.com',
            'password' => 'ejhsdbf'
        ]);
    }
}
