<?php

namespace App\Repositories;


interface PaymentRepository
{
    public function getAll($school_year_id);

	public function getAllStudentsForSchool($school_id,$school_year_id);
}