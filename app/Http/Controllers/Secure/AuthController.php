<?php

namespace App\Http\Controllers\Secure;

use App\Helpers\Thumbnail;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\PasswordConfirmRequest;
use App\Http\Requests\Auth\PasswordResetRequest;
use App\Http\Requests\Secure\ApplicantRequest;
use App\Http\Requests\Secure\UserRequest;
use App\Models\BlockLogin;
use App\Models\LoginHistory;
use App\Models\School;
use App\Models\Session as SessionSchool;
use App\Models\Student;
use App\Models\StudentRegistrationCode;
use App\Models\User;
use App\Models\Visitor;
use App\Repositories\ApplicantRepository;
use App\Repositories\ApplicantWorkRepository;
use App\Repositories\CountryRepository;
use App\Repositories\DenominationRepository;
use App\Repositories\DirectionRepository;
use App\Repositories\DormitoryRepository;
use App\Repositories\EntryModeRepository;
use App\Repositories\IntakePeriodRepository;
use App\Repositories\LevelRepository;
use App\Repositories\MaritalStatusRepository;
use App\Repositories\OptionRepository;
use App\Repositories\ReligionRepository;
use App\Repositories\SchoolRepository;
use App\Repositories\SchoolYearRepository;
use App\Repositories\SectionRepository;
use App\Repositories\SessionRepository;
use App\Repositories\StudentGroupRepository;
use Cartalyst\Sentinel\Laravel\Facades\Reminder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Efriandika\LaravelSettings\Facades\Settings;
use Laracasts\Flash\Flash;
use Sentinel;
use Session;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use App\Http\Controllers\Traits\SharedValuesTrait;

class AuthController extends Controller {
	use SharedValuesTrait;
	protected $redirectTo = '/';
	/**
	 * @var LevelRepository
	 */
	private $levelRepository;
	/**
	 * @var EntryModeRepository
	 */
	private $entryModeRepository;
	/**
	 * @var IntakePeriodRepository
	 */
	private $intakePeriodRepository;
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
	 * @var DirectionRepository
	 */
	private $directionRepository;
	/**
	 * @var SchoolYearRepository
	 */
	private $schoolYearRepository;
	/**
	 * @var SessionRepository
	 */
	private $sessionRepository;
	/**
	 * @var SectionRepository
	 */
	private $sectionRepository;
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
	 * @var OptionRepository
	 */
	private $optionRepository;
	/**
	 * @var ApplicantRepository
	 */
	private $applicantRepository;
	/**
	 * @var ApplicantWorkRepository
	 */
	private $applicantWorkRepository;
	/**
	 * @var SchoolRepository
	 */
	private $schoolRepository;

	/**
	 * AuthController constructor.
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
	 * @param SchoolRepository $schoolRepository
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
		OptionRepository $optionRepository,
		ApplicantRepository $applicantRepository,
		ApplicantWorkRepository $applicantWorkRepository,
		SchoolRepository $schoolRepository
	) {

		$this->levelRepository = $levelRepository;
		$this->entryModeRepository = $entryModeRepository;
		$this->intakePeriodRepository = $intakePeriodRepository;
		$this->countryRepository = $countryRepository;
		$this->maritalStatusRepository = $maritalStatusRepository;
		$this->religionRepository = $religionRepository;
		$this->directionRepository = $directionRepository;
		$this->schoolYearRepository = $schoolYearRepository;
		$this->sessionRepository = $sessionRepository;
		$this->sectionRepository = $sectionRepository;
		$this->applicantGroupRepository = $applicantGroupRepository;
		$this->denominationRepository = $denominationRepository;
		$this->dormitoryRepository = $dormitoryRepository;
		$this->optionRepository = $optionRepository;
		$this->applicantRepository = $applicantRepository;
		$this->applicantWorkRepository = $applicantWorkRepository;
		$this->schoolRepository = $schoolRepository;
	}
	public function index() {
		if ( Sentinel::check() ) {
			return redirect( "/" );
		}

		return view( 'login' );
	}

	/**
	 * Account sign in.
	 *
	 * @return View
	 */
	public function getSignin() {
		if ( Sentinel::check() ) {
			return redirect( "/" );
		}

		return view( 'login' );
	}

	/**
	 * Account sign up.
	 *
	 * @return View
	 */
	public function getSignup() {
		if ( Sentinel::check() ) {
			return redirect( "/" );
		}
		if ( Settings::get( 'self_registration' ) != 'yes' ) {
			return back();
		}

		return view( 'register' );
	}

	/**
	 * Account sign in form processing.
	 *
	 * @param LoginRequest $request
	 *
	 * @return Redirect
	 */
	public function postSignin( LoginRequest $request ) {
		try {
			if ( $user = $this->tryAuthenticate( $request ) ) {
				Sentinel::login( $user );
				if ( ! is_null( BlockLogin::where( 'user_id', $user->id )->first() ) ) {
					Flash::error( trans( 'auth.account_suspended' ) );
					Sentinel::logout( null, true );

					return back()->withInput();
				}
				Flash::success( trans( 'auth.signin_success' ) );

				$this->shareValues();

				$userLogin             = new LoginHistory();
				$userLogin->user_id    = $user->id;
				$userLogin->ip_address = $request->ip();
				$userLogin->save();

				return redirect( "/" );
			}
			Flash::error( trans( 'auth.login_params_not_valid' ) );
		} catch ( NotActivatedException $e ) {
			Flash::error( trans( 'auth.account_not_activated' ) );
		} catch ( ThrottlingException $e ) {
			$delay = $e->getDelay();
			Flash::error( trans( 'auth.account_suspended' ) . $delay . trans( 'auth.second' ) );
		}

		return back()->withInput();
	}

	private function tryAuthenticate( $request ) {
		$user = User::where( 'email', $request->get( 'mobile_email' ) )
		            ->orWhere( 'mobile', $request->get( 'mobile_email' ) )->first();
		if ( ! is_null( $user ) ) {
			if ( Hash::check( $request->get( 'password' ), $user->password ) ) {
				return $user;
			}

			return null;
		}

		return null;
	}

	/**
	 * Account sign up form processing.
	 *
	 * @param UserRequest $request
	 *
	 * @return Redirect
	 */
	public function postSignup( UserRequest $request ) {
		if ( Settings::get( 'self_registration' ) != 'yes' ) {
			return back();
		}

		$registration_code = StudentRegistrationCode::where( 'code', $request->get( 'registration_code' ) )->first();
		if ( ! is_null( $registration_code ) || ! ( Settings::get( 'generate_registration_code' ) == true &&
		                                            Settings::get( 'self_registration_role' ) == 'student' ) ) {
			try {
				$user = Sentinel::registerAndActivate( array (
					'first_name' => $request['first_name'],
					'last_name'  => $request['last_name'],
					'email'      => $request['email'],
					'mobile'     => $request['mobile'],
					'password'   => $request['password'],
				) );
				$role = Sentinel::findRoleBySlug( Settings::get( 'self_registration_role' ) );
				if ( isset( $role ) ) {
					$role->users()->attach( $user );

					if ( Settings::get( 'self_registration_role' ) == 'visitor' ) {
						$visitor          = new Visitor();
						$visitor->user_id = $user->id;
						$visitor->save();

						$visitor->visitor_no = Settings::get( 'visitor_card_prefix' ) . $visitor->id;
						$visitor->save();
					} else if ( Settings::get( 'generate_registration_code' ) == true &&
					            Settings::get( 'self_registration_role' ) == 'student' ) {
						Student::create( [
							'school_year_id' => $registration_code->school_year_id,
							'user_id'        => $user->id,
							'section_id'     => $registration_code->section_id,
							'school_id'      => $registration_code->school_id
						] );

						$registration_code->delete();
					}
				}

				Sentinel::loginAndRemember( $user );

				Flash::success( trans( 'auth.signup_success' ) );

				return redirect( '/' );

			} catch ( \Exception $e ) {
				Flash::warning( trans( 'auth.account_already_exists' ) );
			}

			return back()->withInput();
		} else {
			Flash::warning( trans( 'auth.registration_code_is_not_valid' ) );

			return back()->withInput();
		}
	}

	public function reminders() {
		return view( 'reminders.create' );
	}

	public function remindersStore( PasswordResetRequest $request ) {
		$userFind = User::where( 'email', $request->email )->first();
		if ( isset( $userFind->id ) ) {
			$user = Sentinel::findById( $userFind->id );
			( $reminder = Reminder::exists( $user ) ) || ( $reminder = Reminder::create( $user ) );

			$data = [
				'email'   => $user->email,
				'name'    => $userFind->full_name,
				'subject' => trans( 'auth.reset_your_password' ),
				'code'    => $reminder->code,
				'id'      => $user->id
			];
			Mail::send( 'emails.reminder', $data, function ( $message ) use ( $data ) {
				$message->to( $data['email'], $data['name'] )->subject( $data['subject'] );
			} );

			Session::flash( 'email_message_success', trans( "auth.reset_password_link_send" ) );

			return back();
		}
		Session::flash( 'email_message_warning', trans( "auth.user_dont_exists" ) );

		return back();
	}

	public function edit( $id, $code ) {
		$user = Sentinel::findById( $id );
		if ( Reminder::exists( $user, $code ) ) {
			return view( 'reminders.edit', [ 'id' => $id, 'code' => $code ] );
		} else {
			return redirect( '/signin' );
		}
	}

	public function update( $id, $code, PasswordConfirmRequest $request ) {
		$user     = Sentinel::findById( $id );
		$reminder = Reminder::exists( $user, $code );
		//incorrect info was passed.
		if ( $reminder == false ) {
			Flash::error( trans( "auth.reset_password_failed" ) );

			return redirect( '/' );
		}
		Reminder::complete( $user, $code, $request->password );
		Flash::success( trans( "auth.reset_password_success" ) );

		return redirect( '/signin' );
	}

	/**
	 * Logout page.
	 *
	 * @return Redirect
	 */
	public function getLogout() {
		Sentinel::logout( null, true );
		Flash::success( trans( 'auth.successfully_logout' ) );
		Session::flush();

		return redirect( 'signin' );
	}

	public function getApply() {
		if ( Settings::get( 'can_apply_to_school' ) != 'yes' ) {
			return back();
		}
		$this->generateparams();
		return view('apply');
	}


	public function postApply(ApplicantRequest $request) {
		if ( Settings::get( 'can_apply_to_school' ) != 'yes' ) {
			return back();
		}
		$user = $this->applicantRepository->create( $request->except( 'image_file' ) );

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
		return redirect()->to('signin');
	}
	private function generateParams(){
		$schools = $this->schoolRepository->getAllCanApply()
		                                         ->get()
		                                         ->pluck( 'title', 'id' );
		$countries = $this->countryRepository
			->getAll()
			->get()
			->pluck( 'name', 'id' )
			->toArray();
		view()->share( 'schools', $schools );
		view()->share( 'countries', $countries );
	}

}
