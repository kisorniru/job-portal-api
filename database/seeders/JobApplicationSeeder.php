<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class JobApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('job_applications')->insert([
            'user_id' 		=> 3,
            'job_id' 		=> 2,
        ]);
        
    }
}
