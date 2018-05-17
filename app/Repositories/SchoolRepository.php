<?php

namespace App\Repositories;


interface SchoolRepository
{
    public function getAll();

    public function getAllAdmin();

    public function getAllTeacher();

    public function getAllStudent();

    public function getAllAluministudents($school_id,$schoolYearId);

	public function getAllCanApply();

	public function getAllApplicant();
}