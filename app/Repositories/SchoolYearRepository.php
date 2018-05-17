<?php

namespace App\Repositories;


interface SchoolYearRepository
{
    public function getAll();

	public function getActiveForSchool( $school_id );
}