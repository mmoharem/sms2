<?php

namespace App\Repositories;

use App\Models\FeeCategory;

class FeeCategoryRepositoryEloquent implements FeeCategoryRepository {
	/**
	 * @var FeeCategory
	 */
	private $model;


	/**
	 * FeeCategoryRepositoryEloquent constructor.
	 *
	 * @param FeeCategory $model
	 */
	public function __construct( FeeCategory $model ) {
		$this->model = $model;
	}

	public function getAll() {
		return $this->model;
	}

	public function getAllForSection( $section_id ) {
		return $this->model->where( 'section_id', $section_id );
	}

	public function getAllForSectionCurrency( $section_id, $currency_id ) {
		return $this->model->where( 'section_id', $section_id )->where( 'currency_id', $currency_id );
	}

	public function getAllForSchool( $school_id ) {
		return $this->model->where( 'school_id', $school_id );
	}
}