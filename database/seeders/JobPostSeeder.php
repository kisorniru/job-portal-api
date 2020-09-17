<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class JobPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('job_posts')->insert([
            'user_id' 		    => 2,
            'job_title'         => 'Software Developer',
            'job_description' 	=> 'Developer have to know PHP',
            'salary' 			=> 50000,
            'location' 			=> 'Dhaka',
            'country' 			=> 'Bangladesh',
            'deadline' 			=> '2020-12-12',
        ]);

        DB::table('job_posts')->insert([
            'user_id'           => 2,
            'job_title' 		=> 'Software Engieer',
            'job_description' 	=> 'Engieer have to know PHP',
            'salary' 			=> 100000,
            'location' 			=> 'Dhaka',
            'country' 			=> 'Bangladesh',
            'deadline' 			=> '2020-10-11',
        ]);
    }
}
