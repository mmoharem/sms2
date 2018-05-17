<?php

namespace App\Http\Controllers\Secure;

use App\Helpers\CustomFormUserFields;
use App\Helpers\Thumbnail;
use App\Http\Requests\Secure\ApplicantRequest;
use App\Models\Applicant;
use App\Models\School;
use App\Models\SchoolYear;
use App\Models\Section;
use App\Models\Student;
use App\Models\StudentGroup;
use App\Models\User;
use App\Models\UserDocument;
use App\Repositories\ApplicantRepository;
use App\Repositories\ApplicantWorkRepository;
use App\Repositories\DenominationRepository;
use App\Repositories\DormitoryRepository;
use App\Repositories\OptionRepository;
use App\Repositories\SectionRepository;
use App\Repositories\SessionRepository;
use App\Repositories\StudentGroupRepository;
use App\Repositories\UserRepository;
use App\Repositories\DirectionRepository;
use App\Repositories\LevelRepository;
use App\Repositories\IntakePeriodRepository;
use App\Repositories\EntryModeRepository;
use App\Repositories\CountryRepository;
use App\Repositories\MaritalStatusRepository;
use App\Repositories\ReligionRepository;
use App\Repositories\SchoolYearRepository;
use Yajra\DataTables\Facades\DataTables;
use Sentinel;

class ApplicantController extends SecureController {
	/**
	 * @var SectionRepository
	 */
	private $sectionRepository;
	/**
	 * @var DirectionRepository
	 */
	private $directionRepository;
	/**
	 * @var LevelRepository
	 */
	private $levelRepository;
	/**
	 * @var IntakePeriodRepository
	 */
	private $intakePeriodRepository;
	/**
	 * @var EntryModeRepository
	 */
	private $entryModeRepository;
	/**
	 * @var CountryRepository
	 */
	private $countryRepository;
	/**
	 * @var MaritalStatusRepository
	 */
	private $maritalStatusRepository;
	/**
	 * @var ReligionRepository
	 */
	private $religionRepository;
	/**
	 * @var SchoolYearRepository
	 */
	private $schoolYearRepository;
	/**
	 * @var SessionRepository
	 */
	private $sessionRepository;
	/**
	 * @var StudentGroupRepository
	 */
	private $applicantGroupRepository;
	/**
	 * @var DenominationRepository
	 */
	private $denominationRepository;
	/**
	 * @var DormitoryRepository
	 */
	private $dormitoryRepository;
	/**
	 * @var ApplicantRepository
	 */
	private $applicantRepository;
	/**
	 * @var ApplicantWorkRepository
	 */
	private $applicantWorkRepository;
    /**
     * @var OptionRepository
     */
    private $optionRepository;

    /**
	 * TeacherController constructor.
	 *
	 * @param LevelRepository $levelRepository
	 * @param EntryModeRepository $entryModeRepository
	 * @param IntakePeriodRepository $intakePeriodRepository
	 * @param CountryRepository $countryRepository
	 * @param MaritalStatusRepository $maritalStatusRepository
	 * @param ReligionRepository $religionRepository
	 * @param DirectionRepository $directionRepository
	 * @param SchoolYearRepository $schoolYearRepository
	 * @param SessionRepository $sessionRepository
	 * @param SectionRepository $sectionRepository
	 * @param StudentGroupRepository $applicantGroupRepository
	 * @param DenominationRepository $denominationRepository
	 * @param DormitoryRepository $dormitoryRepository
	 * @param OptionRepository $optionRepository
	 * @param ApplicantRepository $applicantRepository
	 * @param ApplicantWorkRepository $applicantWorkRepository
	 */
	public function __construct(
		LevelRepository $levelRepository,
		EntryModeRepository $entryModeRepository,
		IntakePeriodRepository $intakePeriodRepository,
		CountryRepository $countryRepository,
		MaritalStatusRepository $maritalStatusRepository,
		ReligionRepository $religionRepository,
		DirectionRepository $directionRepository,
		SchoolYearRepository $schoolYearRepository,
		SessionRepository $sessionRepository,
		SectionRepository $sectionRepository,
		StudentGroupRepository $applicantGroupRepository,
		DenominationRepository $denominationRepository,
		DormitoryRepository $dormitoryRepository,
		ApplicantRepository $applicantRepository,
		ApplicantWorkRepository $applicantWorkRepository,
        OptionRepository $optionRepository
	) {
		parent::__construct();
		$this->sectionRepository        = $sectionRepository;
		$this->levelRepository          = $levelRepository;
		$this->entryModeRepository      = $entryModeRepository;
		$this->intakePeriodRepository   = $intakePeriodRepository;
		$this->countryRepository        = $countryRepository;
		$this->maritalStatusRepository  = $maritalStatusRepository;
		$this->religionRepository       = $religionRepository;
		$this->directionRepository      = $directionRepository;
		$this->schoolYearRepository     = $schoolYearRepository;
		$this->sessionRepository        = $sessionRepository;
		$this->applicantGroupRepository = $applicantGroupRepository;
		$this->denominationRepository   = $denominationRepository;
		$this->applicantRepository      = $applicantRepository;
		$this->dormitoryRepository      = $dormitoryRepository;
		$this->applicantWorkRepository = $applicantWorkRepository;
        $this->optionRepository = $optionRepository;

		$this->middleware( 'authorized:applicant.show', [ 'only' => [ 'index', 'data' ] ] );
		$this->middleware( 'authorized:applicant.create', [ 'only' => [ 'create', 'store' ] ] );
		$this->middleware( 'authorized:applicant.edit', [ 'only' => [ 'update', 'edit' ] ] );
		$this->middleware( 'authorized:applicant.delete', [ 'only' => [ 'delete', 'destroy' ] ] );

		view()->share( 'type', 'applicant' );

		$columns = [ 'id', 'full_name', 'email', 'session', 'order', 'actions' ];
		view()->share( 'columns', $columns );
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {
		$title = trans( 'applicant.applicant' );

		$this->generateParams();

		return view( 'applicant.index', compact( 'title' ) );
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create() {
		$title = trans( 'applicant.new' );
		$this->generateParams();
		$applicant_groups_select = [];
		$custom_fields = CustomFormUserFields::getCustomUserFields( 'applicant' );

		return view( 'layouts.create', compact( 'title', 'applicant_groups_select','custom_fields' ) );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param ApplicantRequest $request
	 *
	 * @return Response
	 */
	public function store( ApplicantRequest $request ) {
		$user = $this->applicantRepository->create( $request->except( 'image_file','document', 'document_id') );

		if ( $request->hasFile( 'image_file' ) != "" ) {
			$file      = $request->file( 'image_file' );
			$extension = $file->getClientOriginalExtension();
			$picture   = str_random( 10 ) . '.' . $extension;

			$destinationPath = public_path() . '/uploads/avatar/';
			$file->move( $destinationPath, $picture );
			Thumbnail::generate_image_thumbnail( $destinationPath . $picture, $destinationPath . 'thumb_' . $picture );
			$user->picture = $picture;
			$user->save();
		}

		if ( $request->hasFile( 'document' ) != "" ) {
			$file      = $request->file( 'document' );
			$extension = $file->getClientOriginalExtension();
			$document  = str_random( 10 ) . '.' . $extension;

			$destinationPath = public_path() . '/uploads/documents/';
			$file->move( $destinationPath, $document );

			UserDocument::where( 'user_id', $user->id )->delete();

			$userDocument            = new UserDocument;
			$userDocument->user_id   = $user->id;
			$userDocument->document  = $document;
			$userDocument->option_id = $request->get('document_id');
			$userDocument->save();
		}
		CustomFormUserFields::storeCustomUserField( 'applicant', $user->id, $request );

		return redirect( '/applicant' );
	}

	/**
	 * Display the specified resource.
	 *
	 * @param Applicant $applicant
	 *
	 * @return Response
	 */
	public function show( Applicant $applicant ) {
		$title  = trans( 'applicant.details' );
		$action = 'show';
		$custom_fields = CustomFormUserFields::getCustomUserFieldValues( 'applicant', $applicant->user_id );
		$applicantWorks = $this->applicantWorkRepository->getAllForApplicant($applicant->user_id)->get();

		$document_types = $this->optionRepository->getAllForSchool( session( 'current_school' ) )
		                                         ->where( 'category', 'applicant_document_type' )->get()
		                                         ->map( function ( $option ) {
			                                         return [
				                                         "title" => $option->title,
				                                         "value" => $option->id,
			                                         ];
		                                         } );
		return view( 'layouts.show', compact( 'applicant', 'title', 'action', 'custom_fields','applicantWorks','document_types' ) );
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param Applicant $applicant
	 *
	 * @return Response
	 */
	public function edit( Applicant $applicant ) {
		$title = trans( 'applicant.edit' );
		$this->generateParams();
		$documents     = UserDocument::where( 'user_id', $applicant->user->id )->first();
		$levels = $this->levelRepository->getAllForSection( $applicant->section_id )
		                                ->pluck( 'name', 'id' );

        $custom_fields = CustomFormUserFields::fetchCustomValues('applicant', $applicant->user_id);

		$applicant_groups_select = $this->applicantGroupRepository->getAllForSection( $applicant->section_id )
		                                                          ->pluck( 'title', 'id' );

		return view( 'layouts.edit', compact( 'title', 'applicant', 'documents', 'levels', 'applicant_groups_select','custom_fields' ) );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param ApplicantRequest $request
	 * @param Applicant $applicant
	 *
	 * @return Response
	 */
	public function update( ApplicantRequest $request, Applicant $applicant ) {
		$applicant->update( $request->only( 'section_id', 'order',
			'level_of_adm', 'level_id', 'intake_period_id', 'campus_id' ) );
		$applicant->save();
		if ( $request->password != "" ) {
			$applicant->user->password = bcrypt( $request->password );
		}
		if ( $request->hasFile( 'image_file' ) != "" ) {
			$file      = $request->file( 'image_file' );
			$extension = $file->getClientOriginalExtension();
			$picture   = str_random( 10 ) . '.' . $extension;

			$destinationPath = public_path() . '/uploads/avatar/';
			$file->move( $destinationPath, $picture );
			Thumbnail::generate_image_thumbnail( $destinationPath . $picture, $destinationPath . 'thumb_' . $picture );
			$applicant->user->picture = $picture;
			$applicant->user->save();
		}

		$applicant->user->update( $request->except( 'section_id', 'order', 'password', 'document', 'document_id', 'image_file',
			'entry_mode_id', 'country_id', 'marital_status_id', 'no_of_children', 'religion_id', 'denomination',
			'disability', 'contact_relation', 'contact_name', 'contact_address', 'contact_phone',
			'contact_email' ) );

		if ( $request->hasFile( 'document' ) != "" ) {
			$file      = $request->file( 'document' );
			$user      = $applicant->user;
			$extension = $file->getClientOriginalExtension();
			$document  = str_random( 10 ) . '.' . $extension;

			$destinationPath = public_path() . '/uploads/documents/';
			$file->move( $destinationPath, $document );

			UserDocument::where( 'user_id', $user->id )->delete();

			$userDocument            = new UserDocument;
			$userDocument->user_id   = $user->id;
			$userDocument->document  = $document;
			$userDocument->option_id = $request->document_id;
			$userDocument->save();
		}
		CustomFormUserFields::updateCustomUserField( 'applicant', $applicant->user->id, $request );

		return redirect( '/applicant' );
	}

	/**
	 * @param Applicant $applicant
	 *
	 * @return Response
	 */
	public function delete( Applicant $applicant ) {
		$title         = trans( 'applicant.delete' );
		$applicantWorks = $this->applicantWorkRepository->getAllForApplicant($applicant->user_id)->get();

		$document_types = $this->optionRepository->getAllForSchool( session( 'current_school' ) )
		                                         ->where( 'category', 'applicant_document_type' )->get()
		                                         ->map( function ( $option ) {
			                                         return [
				                                         "title" => $option->title,
				                                         "value" => $option->id,
			                                         ];
		                                         } );

		return view( '/applicant/delete', compact( 'applicant', 'title', 'applicantWorks','document_types' ) );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Applicant $applicant
	 *
	 * @return Response
	 */
	public function destroy( Applicant $applicant ) {
		$applicant->delete();

		return redirect( '/applicant' );
	}

	public function moveToStudent( Applicant $applicant ) {

		$student_new = Student::create( [
			'school_year_id'   => $applicant->school_year_id,
			'user_id'          => $applicant->user_id,
			'section_id'       => $applicant->section_id,
			'school_id'        => $applicant->school_id,
			'order'            => $applicant->order,
			'intake_period_id' => $applicant->intake_period_id,
			'level_of_adm'     => $applicant->level_of_adm,
			'level_id'         => $applicant->level_id,
			'dormitory_id'     => $applicant->dormitory_id
		] );

		$school              = School::find( $applicant->school_id );
		$yearCode            = SchoolYear::find( $applicant->school_year_id);
		$section             = Section::find( $applicant->section_id);
		$programmeCode       = StudentGroup::find( $applicant->student_group_id);
		$student_new->student_no = $school->student_card_prefix . '/' .
		                           ((isset($section->id_code))?$section->id_code . '/' :"").
		                           ((isset($programmeCode->direction->id_code))?$programmeCode->direction->id_code . '/' :"").
		                           ((isset($yearCode->id_code))?$yearCode->id_code . '/' :"").
		                           $school->next_id_no;
		$student_new->save();

		$school->next_id_no = $school->next_id_no + 1;
		$school->save();

		$role = Sentinel::findRoleBySlug( 'applicant' );
		$role->users()->attach( $applicant );

		$applicant->delete();

		return redirect( '/applicant' );
	}

	public function data($first_name = null, $last_name = null, $applicant_id = null,
		$country_id = null, $session_id = null, $direction_id = null, $section_id = null, $level_id = null, $entry_mode_id = null,
		$gender = null, $marital_status_id = null, $dormitory_id = null) {
		$request    = [
			'first_name'        => $first_name,
			'last_name'         => $last_name,
			'applicant_id'      => $applicant_id,
			'session_id'        => $session_id,
			'direction_id'      => $direction_id,
			'section_id'        => $section_id,
			'level_id'          => $level_id,
			'entry_mode_id'     => $entry_mode_id,
			'gender'            => $gender,
			'marital_status_id' => $marital_status_id,
			'dormitory_id'      => $dormitory_id,
			'country_id'      => $country_id
		];
		$applicants = $this->applicantRepository->getAllForSchoolWithFilter( session( 'current_school' ), session( 'current_school_year' ), $request )
		                                        ->map( function ( $applicant ) {
			                                        return [
				                                        'id'        => $applicant->id,
				                                        'full_name' => $applicant->full_name,
				                                        'email'     => $applicant->email,
				                                        'session'   => $applicant->section,
				                                        'order'     => $applicant->order,
				                                        'user_id'   => $applicant->user_id
			                                        ];
		                                        } );

		return Datatables::make( $applicants )
		                 ->addColumn( 'actions', '@if(Sentinel::getUser()->inRole(\'super_admin\') || (Sentinel::getUser()->inRole(\'admin\') && array_key_exists(\'applicant.edit\', Sentinel::getUser()->permissions)))
                                        <a href="{{ url(\'/applicant/\' . $id . \'/edit\' ) }}" class="btn btn-success btn-sm" >
                                            <i class="fa fa-pencil-square-o "></i>  {{ trans("table.edit") }}</a>
                                    @endif
                                   @if(Sentinel::getUser()->inRole(\'super_admin\') || (Sentinel::getUser()->inRole(\'admin\') && array_key_exists(\'applicant.show\', Sentinel::getUser()->permissions)))
                                    <a href="{{ url(\'/applicant/\' . $id . \'/show\' ) }}" class="btn btn-primary btn-sm" >
                                            <i class="fa fa-eye"></i>  {{ trans("table.details") }}</a>
                                    @endif
                                   @if((Sentinel::getUser()->inRole(\'super_admin\') || (Sentinel::getUser()->inRole(\'admin\') && array_key_exists(\'student.create\', Sentinel::getUser()->permissions))) && !is_null($session))
                                    <a href="{{ url(\'/applicant/\' . $id . \'/move_to_student\' ) }}" class="btn btn-info btn-sm" >
                                            <i class="fa fa-arrows"></i>  {{ trans("applicant.move_to_student") }}</a>
                                    @endif
                                    @if(Sentinel::getUser()->inRole(\'super_admin\') || (Sentinel::getUser()->inRole(\'admin\') && array_key_exists(\'applicant.delete\', Sentinel::getUser()->permissions)))
                                     <a href="{{ url(\'/applicant/\' . $id . \'/delete\' ) }}" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> {{ trans("table.delete") }}</a>
                                      @endif' )
		                 ->removeColumn( 'user_id' )
		                 ->rawColumns( [ 'actions' ] )->make();
	}

	private function generateParams() {
		$sections = $this->sectionRepository
			->getAllForSchoolYearSchool( session( 'current_school_year' ), session( 'current_school' ) )
			->get()
			->pluck( 'title', 'id' );

		$sessions = $this->sessionRepository
			->getAllForSchool( session( 'current_school' ) )
			->get()
			->pluck( 'name', 'id' );

		$levels = $this->levelRepository
			->getAllForSchool( session( 'current_school' ) )
			->get()
			->pluck( 'name', 'id' );

		$entrymodes = $this->entryModeRepository
			->getAllForSchool( session( 'current_school' ) )
			->get()
			->pluck( 'name', 'id' )
			->toArray();

		$intakeperiods = $this->intakePeriodRepository
			->getAllForSchool( session( 'current_school' ) )
			->get()
			->pluck( 'name', 'id' );

		$directions = $this->directionRepository
			->getAllForSchool( session( 'current_school' ) )
			->get()
			->pluck( 'title', 'id' );

		$dormitories = $this->dormitoryRepository->getAll()
		                                         ->get()
		                                         ->pluck( 'title', 'id' );

		$countries = $this->countryRepository
			->getAll()
			->get()
			->pluck( 'name', 'id' )
			->toArray();

		$maritalStatus = $this->maritalStatusRepository
			->getAll()
			->get()
			->pluck( 'name', 'id' );

		$religion = $this->religionRepository
			->getAll()
			->get()
			->pluck( 'name', 'id' );

		$denominations = $this->denominationRepository
			->getAll()
			->get()
			->pluck( 'name', 'id' );

		$document_types = $this->optionRepository->getAllForSchool( session( 'current_school' ) )
		                                         ->where( 'category', 'applicant_document_type' )->get()
		                                         ->map( function ( $option ) {
			                                         return [
				                                         "title" => $option->title,
				                                         "value" => $option->id,
			                                         ];
		                                         } );

		view()->share( 'sections', $sections );
		view()->share( 'sessions', $sessions );
		view()->share( 'levels', $levels );
		view()->share( 'entrymodes', $entrymodes );
		view()->share( 'countries', $countries );
		view()->share( 'intakeperiods', $intakeperiods );
		view()->share( 'dormitories', $dormitories );
		view()->share( 'maritalStatus', $maritalStatus );
		view()->share( 'religion', $religion );
		view()->share( 'denominations', $denominations );
		view()->share( 'document_types', $document_types );
		view()->share( 'directions', $directions );
	}

	/**
	 * FOR applicants
	 *
	 * @return Response
	 */
	public function personal() {
		if ( ! Sentinel::check() ) {
			return redirect( "/" );
		}
		$title    = trans( 'applicant.details' );

		$custom_fields = CustomFormUserFields::getCustomUserFields( 'applicant' );
		$applicant     = $this->applicantRepository->getAllForSchoolSchoolYearAndUser(session('current_school'),
																					session('current_school_year'),
																					Sentinel::getUser()->id)->first();
		$document_types = $this->optionRepository->getAllForSchool( session( 'current_school' ) )
		                                         ->where( 'category', 'applicant_document_type' )->get()
		                                         ->map( function ( $option ) {
			                                         return [
				                                         "title" => $option->title,
				                                         "value" => $option->id,
			                                         ];
		                                         } );

		return view( 'applicant.applicant_info', compact( 'title', 'applicant', 'custom_fields','document_types' ) );
	}
}
