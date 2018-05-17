<?php

namespace App\Repositories;

use App\Models\SchoolYear;

class SchoolYearRepositoryEloquent implements SchoolYearRepository
{
    /**
     * @var SchoolYear
     */
    private $model;


    /**
     * SchoolYearRepositoryEloquent constructor.
     * @param SchoolYear $model
     */
    public function __construct(SchoolYear $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model;
    }

	public function getActiveForSchool( $school_id ) {
		$schoolYearId = 0;
		$schoolYear = $this->model->where('school_id', $school_id)->orderBy('id', 'desc')->first();
		//if there school year for selected school
		if(!is_null($schoolYear)){
			return $schoolYear->id;
		}else{
			//if there school year for all schools
			$schoolYear = $this->model->whereNull('school_id')->orderBy('id', 'desc')->first();
			if(!is_null($schoolYear)){
				return $schoolYear->id;
			}else{
				//no school years
				return $schoolYearId;
			}
		}
	}
}