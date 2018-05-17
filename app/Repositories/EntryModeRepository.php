<?php

namespace App\Repositories;


interface EntryModeRepository
{
    public function getAll();

    public function getAllForSchool($school_id);

}