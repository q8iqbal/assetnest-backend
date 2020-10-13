<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('activity')->count() == 0){
            DB::table('activity')->insert([
                [
                    'activity' => 'Tambah Admin',
                ],
                [
                    'activity' => 'Edit Admin',
                ],
                [
                    'activity' => 'Hapus Admin',
                ],
                [
                    'activity' => 'Tambah Staff',
                ],
                [
                    'activity' => 'Edit Staff',
                ],
                [
                    'activity' => 'Hapus Staff',
                ],
            ]);
        }else{
            echo "\e[31mTable is not empty, therefore NOT ";
        }
    }
}
