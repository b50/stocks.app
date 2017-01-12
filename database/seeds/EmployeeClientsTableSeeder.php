<?php

use Illuminate\Database\Seeder;

class EmployeeClientTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('employee_clients')->delete();
        \App\Models\EmployeeClient::create([
            'employee_id' => 1,
            'client_id' => '3',
        ]);
        \App\Models\EmployeeClient::create([
            'employee_id' => 1,
            'client_id' => '4',
        ]);
    }

}