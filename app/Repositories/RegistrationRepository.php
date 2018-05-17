<?php

namespace App\Repositories;


interface RegistrationRepository
{
    public function getAll();

	public function getAllStudentsForSchool($school_id);


}