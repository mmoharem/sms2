<?php

namespace App\Repositories;


interface FeeCategoryRepository
{
    public function getAll();

    public function getAllForSection($section_id);

    public function getAllForSectionCurrency($section_id, $currency_id);

	public function getAllForSchool($school_id);
}

