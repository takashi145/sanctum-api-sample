<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tasks')->insert([
            [
                'user_id' => 1,
                'title' => 'test1',
                'description' => 'testtesttest',
                'completed' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'title' => 'test2',
                'description' => 'testtesttest',
                'completed' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'title' => 'test3',
                'description' => 'testtesttest',
                'completed' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
