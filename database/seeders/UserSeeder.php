<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' 		=> 'Mr.',
            'last_name' 		=> 'Admin',
            'role' 		        => 'admin',
            'profile_picture' 	=> '',
            'resume' 			=> '',
            'business_name'		=> '',
            'email' 			=> 'admin@admin.com',
            'password' 			=> Hash::make('123456'),
        ]);


        DB::table('users')->insert([
            'first_name' 		=> 'Mr.',
            'last_name' 		=> 'Company',
            'role' 		        => 'company',
            'profile_picture' 	=> '',
            'resume' 			=> '',
            'business_name'		=> 'Company',
            'email' 			=> 'company@company.com',
            'password' 			=> Hash::make('123456'),
        ]);

        DB::table('users')->insert([
            'first_name' 		=> 'Mr.',
            'last_name' 		=> 'Applicant',
            'role' 		        => 'applicant',
            'profile_picture' 	=> '',
            'resume' 			=> '',
            'business_name'		=> '',
            'email' 			=> 'applicant@applicant.com',
            'password' 			=> Hash::make('123456'),
        ]);
    }
}
