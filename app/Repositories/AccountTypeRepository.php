<?php

namespace App\Repositories;


interface AccountTypeRepository
{
    public function getAll();

    public function getAllForSchool($school_id);

}