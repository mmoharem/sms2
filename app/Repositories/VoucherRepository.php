<?php

namespace App\Repositories;


interface VoucherRepository
{
    public function getAll();

    public function getAllForSchool($school_id);

}