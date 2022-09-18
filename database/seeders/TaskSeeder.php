<?php

namespace Database\Seeders;

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
                'title' => 'test1',
                'description' => 'testtesttest'
            ],
            [
                'title' => 'test2',
                'description' => 'testtesttest'
            ],
            [
                'title' => 'test3',
                'description' => 'testtesttest'
            ],
        ]);
    }
}
