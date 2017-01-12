<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('users')->delete();
        \App\Models\User::create([
            'email' => 'stocks@gmail.com',
            'password' =>'1234',
            'first_name' => 'Bill',
            'last_name' => 'Chater',
            'id' => 1,
            'about' => '1234',
            'group' => 'Admin',
            'street1' => '5 Dorset Street',
            'city' => 'London',
            'Region' => 'England',
            'post_code' => 'W1U 6QJ',
            'country' => 'United Kingdom',
            'mobile' => '020 444 222 111'
        ]);
        \App\Models\User::create([
            'id' => 2,
            'email' => 'sarah@outlook.co.uk',
            'password' => '1234',
            'first_name' => 'Sarah',
            'last_name' => 'Smith',
            'group' => 'Employee',
            'street1' => 'Bodiam Castle',
            'street2' => 'Bodiam, Robertsbridge',
            'city' => '',
            'Region' => 'England',
            'post_code' => 'TN32 5UA',
            'country' => 'United Kingdom',
            'work_phone' => '020 4343 2222'
        ]);
        \App\Models\User::create([
            'id' => 3,
            'email' => 'bill@gmail.com',
            'password' => '1234',
            'first_name' => 'Danny',
            'last_name' => 'Bourne',
            'group' => 'Client',
            'street1' => 'Holly Lodge',
            'street2' => 'Surrey',
            'post_code' => 'TW10 5HS',
            'country' => 'United Kingdom',
            'mobile' => '020 4433 2328'
        ]);
        \App\Models\User::create([
            'id' => 4,
            'email' => 'betty@outlook.com',
            'password' => '1234',
            'first_name' => 'Betty',
            'last_name' => 'Blue',
            'group' => 'Client',
            'street1' => '4 Jingshan Front St',
            'street2' => 'Dongcheng Qu',
            'city' => 'Beijing',
            'country' => 'China',
            'mobile' => '10 8500 7421'
        ]);
        \App\Models\User::create([
            'id' => 5,
            'email' => 'barack-obama@usa.gov',
            'password' => '1234',
            'first_name' => 'Barack',
            'last_name' => 'Obama',
            'group' => 'Client',
            'street1' => '1600 Pennsylvania Avenue',
            'city' => 'Northwest',
            'Region' => 'Washington, D.C.',
            'post_code' => '20500',
            'country' => 'USA',
            'mobile' => '1 (333) 555-333',
            'work_phone' => '(917) 222-333',
            'home_phone' => '(914) 444-222'
        ]);
    }

}