<?php

namespace App\Repositories;


interface DirectionRepository
{
    public function getAll();

    public function getAllForSchool($school_id);
}