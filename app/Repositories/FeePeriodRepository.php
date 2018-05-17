<?php

namespace App\Repositories;


interface FeePeriodRepository
{
    public function getAll();

    public function getAllForSchool($school_id);

}