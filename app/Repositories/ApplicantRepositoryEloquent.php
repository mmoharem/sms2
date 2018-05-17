<?php

namespace App\Repositories;

use App\Models\Applicant;
use App\Models\FeeCategory;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Option;
use App\Models\School;
use App\Models\Semester;
use App\Models\StudentGroup;
use App\Models\User;
use Efriandika\LaravelSettings\Facades\Settings;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Sentinel;

class ApplicantRepositoryEloquent implements ApplicantRepository {
	/**
	 * @var Applicant
	 */
	private $model;


	/**
	 * ApplicantRepositoryEloquent constructor.
	 *
	 * @param Applicant $model
	 */
	public function __construct( Applicant $model ) {
		$this->model = $model;
	}

	public function getAll() {
		return $this->model;
	}

	public function getAllForSchool( $school_id ) {
		return $this->model->where( 'school_id', $school_id );
	}

	public function getAllForSchoolYear( $school_year_id ) {
		return $this->model->where( 'school_year_id', $school_year_id );
	}

	public function getAllForSchoolSchoolYear( $school_id, $school_year_id ) {
		return $this->model->where( 'school_id', $school_id )->where( 'school_year_id', $school_year_id );
	}

	public function getAllForSchoolWithFilter( $school_id, $school_year_id, $request = null ) {
		$applicantItems = new Collection( [] );
		$this->model->join( 'users', 'users.id', '=', 'applicants.user_id' )
		            ->leftJoin( 'sections', 'sections.id', '=', 'applicants.section_id' )
		            ->leftJoin( 'levels', 'levels.id', '=', 'applicants.level_of_adm' )
		            ->whereNull( 'users.deleted_at' )
		            ->whereNull( 'sections.deleted_at' )
		            ->where( 'applicants.school_id', $school_id )
		            ->where( function($w) use ($school_year_id){
		                $w->where('applicants.school_year_id', $school_year_id)
                            ->orWhere('applicants.school_year_id', 0);
                    })
		            ->where( function ( $w ) use ( $request ) {
			            if ( ! is_null( $request['first_name'] ) && $request['first_name'] != "*" ) {
				            $w->where( 'users.first_name', 'LIKE', '%' . $request['first_name'] . '%' );
			            }
			            if ( ! is_null( $request['last_name'] ) &&  $request['last_name'] != "*" ) {
				            $w->where( 'users.last_name', 'LIKE', '%' . $request['last_name'] . '%' );
			            }
			            if ( ! is_null( $request['applicant_id'] ) && $request['applicant_id'] != "*" ) {
				            $w->where( 'applicants.id', 'LIKE', '%' . $request['applicant_id'] . '%' );
			            }
			            if ( ! is_null( $request['country_id'] ) && $request['country_id'] != "*" &&
                            $request['country_id'] != "null" ) {
				            $w->where( 'users.country_id', $request['country_id'] );
			            }
			            if ( ! is_null( $request['session_id'] ) && $request['session_id'] != "*" && $request['session_id'] != "null" ) {
				            $w->where( 'sections.session_id', $request['session_id'] );
			            }
			            if ( ! is_null( $request['level_id'] ) && $request['level_id'] != "*" && $request['level_id'] != "null" ) {
				            $w->where( 'levels.id', $request['level_id'] );
			            }
			            if ( ! is_null( $request['entry_mode_id'] ) && $request['entry_mode_id'] != "*" && $request['entry_mode_id'] != "null" ) {
				            $w->where( 'users.entry_mode_id', $request['entry_mode_id'] );
			            }
			            if ( ! is_null( $request['gender'] ) && $request['gender'] != "*" ) {
				            $w->where( 'users.gender', $request['gender'] );
			            }
			            if ( ! is_null( $request['marital_status_id'] ) && $request['marital_status_id'] != "*" && $request['dormitory_id'] != "null" ) {
				            $w->where( 'users.marital_status_id', $request['marital_status_id'] );
			            }
			            if ( ! is_null( $request['dormitory_id'] ) && $request['dormitory_id'] != "*" && $request['dormitory_id'] != "null") {
				            $w->where( 'applicants.dormitory_id', $request['dormitory_id'] );
			            }
			            if ( ! is_null( $request['direction_id'] ) && $request['direction_id'] != "*" &&
                            $request['direction_id'] != "null") {
				            $w->where( 'applicants.direction_id', $request['direction_id'] );
			            }
		            } )->orderBy( 'order' )
		            ->select( 'users.id as user_id', 'applicants.id as id', 'applicants.order as order',
			            DB::raw( 'CONCAT(users.first_name, " ", COALESCE(users.middle_name, ""), " ", users.last_name) as full_name' ),
			            'sections.title as section', 'users.email as email' )
		            ->get()
		            ->each( function ( $applicantItem ) use ( $applicantItems ) {
			            $applicantItems->push( $applicantItem );
		            } );

		return $applicantItems;
	}

	public function create( array $data, $activate = true ) {
		$user_exists = User::where( 'email', $data['email'] )->first();
		if ( ! isset( $user_exists->id ) ) {
			$user_tem = Sentinel::registerAndActivate( $data, $activate );
			$user     = User::find( $user_tem->id );
		} else {
			$user = $user_exists;
		}
		try {
			$role = Sentinel::findRoleBySlug( 'applicant' );
			$role->users()->attach( $user );
		} catch ( \Exception $e ) {
		}
		$user->update( [
			'birth_date'        => $data['birth_date'],
			'birth_city'        => isset( $data['birth_city'] ) ? $data['birth_city'] : "-",
			'gender'            => isset( $data['gender'] ) ? $data['gender'] : 0,
			'address'           => isset( $data['address'] ) ? $data['address'] : "-",
			'mobile'            => isset( $data['mobile'] ) ? $data['mobile'] : 0,
			'phone'             => isset( $data['phone'] ) ? $data['phone'] : 0,
			'title'             => isset( $data['title'] ) ? $data['title'] : 0,
			'middle_name'       => isset( $data['middle_name'] ) ? $data['middle_name'] : '',
			'country_id'        => isset( $data['country_id'] ) ? $data['country_id'] : 0,
			'entry_mode_id'     => isset( $data['entry_mode_id'] ) ? $data['entry_mode_id'] : 0,
			'marital_status_id' => isset( $data['marital_status_id'] ) ? $data['marital_status_id'] : 0,
			'no_of_children'    => isset( $data['no_of_children'] ) ? $data['no_of_children'] : 0,
			'religion_id'       => isset( $data['religion_id'] ) ? $data['religion_id'] : 0,
			'disability'        => isset( $data['disability'] ) ? $data['disability'] : "",
			'contact_relation'  => isset( $data['contact_relation'] ) ? $data['contact_relation'] : "",
			'contact_name'      => isset( $data['contact_name'] ) ? $data['contact_name'] : "",
			'contact_address'   => isset( $data['contact_address'] ) ? $data['contact_address'] : "",
			'contact_phone'     => isset( $data['contact_phone'] ) ? $data['contact_phone'] : "",
			'contact_email'     => isset( $data['contact_email'] ) ? $data['contact_email'] : "",
			'denomination_id'   => isset( $data['denomination_id'] ) ? $data['denomination_id'] : 0,
		] );

		if ( is_null( session( 'current_school' ) ) && Settings::get( 'multi_school' ) == 'no' && isset( School::first()->id ) ) {
			session( 'current_school', School::first()->id );
		}

		$applicant                   = new Applicant();
		$applicant->section_id       = isset( $data['section_id'] ) ?$data['section_id'] : 0;
		$applicant->direction_id     = isset( $data['direction_id'] ) ?$data['direction_id'] : 0;
		$applicant->order            = isset( $data['order'] ) ? $data['order'] : 0;
		$applicant->school_year_id   = isset( $data['school_year_id'] ) ? $data['school_year_id'] : 0;
		$applicant->school_id        = isset( $data['school_id'] ) ? $data['school_id'] : 0;
		$applicant->level_of_adm     = isset( $data['level_of_adm'] ) ? $data['level_of_adm'] : 0;
		$applicant->dormitory_id     = isset( $data['dormitory_id'] ) ? $data['dormitory_id'] : 0;
		$applicant->student_group_id = isset( $data['student_group_id'] ) ? $data['student_group_id'] : 0;
		$applicant->user_id          = $user->id;
		$applicant->save();

		if ( isset( $data['student_group_id'] ) && ! is_null( $data['student_group_id'] ) ) {
			$applicantGroup = StudentGroup::find( $data['student_group_id'] );
			$applicantGroup->applicants()->attach( $applicant->id );

			if ( isset( $data['section_id'] ) && $data['section_id'] != "" ) {
                $fees = FeeCategory::where('section_id', $data['section_id'])
                    ->where('school_id', '=', session('current_school'))
                    ->get();
                if (!is_null($fees)) {

                    $currentSemester = Semester::where('school_year_id', '=', session('current_school_year'))
                        ->orderBy('id', 'desc')
                        ->first();

                    $currency = Option::where('title', Settings::get('currency'))->where('category', 'currency')->first();

                    $invoice = new Invoice();
                    $invoice->user_id = $user->id;
                    $invoice->school_id = isset($data['school_id']) ? $data['school_id'] : 0;
                    $invoice->school_year_id = isset($data['school_year_id']) ? $data['school_year_id'] : 0;
                    $invoice->semester_id = isset($currentSemester->id)?$currentSemester->id:0;
                    $invoice->currency_id = isset($currency->id)?$currency->id:0;
                    $invoice->total_fees = $fees->sum('amount');
                    $invoice->amount = $fees->sum('amount');
                    $invoice->save();

                    foreach ($fees as $fee) {
                        InvoiceItem::create([
                            'option_id' => 0,
                            'option_title' => $fee->title,
                            'option_amount' => $fee->amount,
                            'invoice_id' => $invoice->id,
                            'quantity' => 1
                        ]);
                    }
                }
            }
		}
		return $user;
	}

	public function getAllForSchoolSchoolYearAndUser( $school_id, $school_year_id, $user_id ) {
		return $this->model->where( 'user_id', $user_id )->where( 'school_year_id', $school_year_id )->where( 'school_id', $school_id );
	}
}