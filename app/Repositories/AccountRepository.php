<?php

namespace App\Repositories;


interface AccountRepository
{
    public function getAll();

    public function getAllForSchool($school_id);

}