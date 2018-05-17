<?php

namespace App\Repositories;


interface ExpenseCategoryRepository
{
    public function getAll();

    public function getAllForSchool($school_id);
}