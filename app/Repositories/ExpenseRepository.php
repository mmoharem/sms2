<?php

namespace App\Repositories;


interface ExpenseRepository
{
    public function getAll();

    public function getAllForSchoolAndSchoolYear($school_id, $school_year_id);
}