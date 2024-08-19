<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        //delete all record in the database table
        User::truncate();
        //re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        User::factory()->count(30)->create();
    }
}
