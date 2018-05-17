<?php

use App\StaffLeaveType;
use Illuminate\Database\Seeder;

class StaffLeaveTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

	    StaffLeaveType::create([
		    'school_id' => 0,
		    'title' => 'Free day',
		    'value' => '5'
	    ]);

	    StaffLeaveType::create([
		    'school_id' => 0,
		    'title' => 'Vocation',
		    'value' => '21'
	    ]);

	    StaffLeaveType::create([
		    'school_id' => 0,
		    'title' => 'Sick',
		    'value' => '0'
	    ]);
    }
}
