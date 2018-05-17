<?php

namespace App\Repositories;


interface SessionRepository
{
    public function getAll();

    public function getAllForSchool($school_id);

}