<?php

namespace App\Repositories;


interface LevelRepository
{
    public function getAll();

    public function getAllForSchool($school_id);

    public function getAllForSection($section_id);

}