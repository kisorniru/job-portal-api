<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('skills')->insert([
            'name' 		=> 'PHP',
        ]);

        DB::table('skills')->insert([
            'name' 		=> 'Java',
        ]);

        DB::table('skills')->insert([
            'name' 		=> 'Python',
        ]);

        DB::table('skills')->insert([
            'name' 		=> 'JavaScript',
        ]);
    }
}
