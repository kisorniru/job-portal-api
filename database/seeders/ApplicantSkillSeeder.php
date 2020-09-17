<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class ApplicantSkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('applicant_skills')->insert([
            'user_id' 		=> 3,
            'skill_id' 		=> 1,
        ]);

        DB::table('applicant_skills')->insert([
            'user_id' 		=> 3,
            'skill_id' 		=> 2,
        ]);

        DB::table('applicant_skills')->insert([
            'user_id' 		=> 3,
            'skill_id' 		=> 3,
        ]);

        DB::table('applicant_skills')->insert([
            'user_id' 		=> 3,
            'skill_id' 		=> 4,
        ]);
    }
}
