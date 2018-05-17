<?php

/****************   Model binding into route **************************/

Route::model('teacher_user', 'App\Models\User');
Route::model('human_resource', 'App\Models\User');
Route::model('school_admin', 'App\Models\User');
Route::model('librarian_user', 'App\Models\User');
Route::model('doorman_user', 'App\Models\User');
Route::model('student_user', 'App\Models\User');
Route::model('parent_user', 'App\Models\User');
Route::model('visitor', 'App\Models\User');
Route::model('applicant_user', 'App\Models\User');
Route::model('accountant', 'App\Models\User');

Route::pattern('slug', '[a-z0-9-]+');
Route::pattern('version', '[0-9.]+');

/******************   APP routes  ********************************/

//default route - homepage for all roles
Route::get('/', 'Secure\SecureController@showHome');
Route::get('verify', 'VerifyController@index');
Route::post('verify', 'VerifyController@verify');
Route::get('release_license', 'ReleaseLicenseController@index');
Route::post('release_license', 'ReleaseLicenseController@releaseLicense');
Route::post('events', 'Secure\SecureController@events');
Route::get('language/setlang/{slug}', 'Secure\LanguageController@setlang');

//route after user login into system
Route::get('signin', 'Secure\AuthController@getSignin');
Route::post('signin', 'Secure\AuthController@postSignin');
Route::get('signup', 'Secure\AuthController@getSignup');
Route::post('signup', 'Secure\AuthController@postSignup');
Route::get('apply', 'Secure\AuthController@getApply');
Route::post('apply', 'Secure\AuthController@postApply');
Route::get('apply/{school}/custom_data', 'Secure\AuthController@customData');
Route::get('apply/{session}/sections', 'Secure\AuthController@getSectionBySession');
Route::get('apply/{section}/levels', 'Secure\StudentController@getLevelsBySection');
Route::get('apply/{school}/directions', 'Secure\SchoolController@directions');

Route::get('passwordreset/{id}/{token}', ['as' => 'reminders.edit', 'uses' => 'Secure\AuthController@edit']);
Route::post('passwordreset/{id}/{token}', ['as' => 'reminders.update', 'uses' => 'Secure\AuthController@update']);
Route::get('passwordreset', 'Secure\AuthController@reminders');
Route::post('passwordreset', 'Secure\AuthController@remindersStore');

Route::get('logout', 'Secure\AuthController@getLogout');
Route::get('activate/{activationCode}', 'Secure\AuthController@getActivate');

Route::get('about_school_page', 'Frontend\PageController@aboutSchoolPage');
Route::get('about_teachers_page', 'Frontend\PageController@aboutTeachersPage');
Route::get('blogs', 'Frontend\BlogController@index');
Route::get('faqs', 'Frontend\FaqController@index');
Route::get('contact', 'Frontend\ContactController@index');
Route::post('contact', 'Frontend\ContactController@contact');
Route::get('page/{slug?}', 'Frontend\PageController@show');
Route::get('blogitem/{slug?}', 'Frontend\BlogController@blog');

Route::group(array('middleware' => ['sentinel', 'xss_protection']), function () {

    Route::get('change-lang/{slug}', 'Secure\ProfileController@changeLang');
    Route::get('login_as_user/{user}', 'Secure\ProfileController@loginAsUser');
    Route::get('back_to_admin', 'Secure\ProfileController@backToAdmin');
    Route::get('back_to_super_admin', 'Secure\ProfileController@backToSuperAdmin');
    Route::get('back_to_admin_super_admin', 'Secure\ProfileController@backToAdminSuperAdmin');

    Route::get('profile', 'Secure\ProfileController@getProfile');
    Route::get('change_account', 'Secure\ProfileController@getAccount');
    Route::post('change_account', 'Secure\ProfileController@postAccount');
    Route::post('webcam', 'Secure\ProfileController@postWebcam');
    Route::get('my_certificate', 'Secure\ProfileController@getCertificate');

    Route::get('setyear/{id}', 'Secure\ProfileController@setYear');
    Route::get('setschool/{id}', 'Secure\ProfileController@setSchool');
    Route::get('setgroup/{id}', 'Secure\ProfileController@setGroup');
    Route::get('setstudent/{id}', 'Secure\ProfileController@setStudent');

    Route::get('mailbox', 'Secure\MailboxController@index');
    Route::get('mailbox/sent', 'Secure\MailboxController@sent');
	Route::get('mailbox/compose', 'Secure\MailboxController@compose');
	Route::post('mailbox/compose', 'Secure\MailboxController@send_compose');
    Route::get('mailbox/{message}/delete', 'Secure\MailboxController@delete');
    Route::get('mailbox/{message}/replay', 'Secure\MailboxController@replay');
    Route::put('mailbox/{message}/replay', 'Secure\MailboxController@send_replay');
	Route::get('mailbox/{message}/download', 'Secure\MailboxController@download');

    Route::get('notification/all', 'Secure\NotificationController@getAllData');
    Route::get('notification/data', 'Secure\NotificationController@data');
    Route::get('notification/{notification}/show', 'Secure\NotificationController@show');
    Route::get('notification/{notification}/edit', 'Secure\NotificationController@edit');
    Route::get('notification/{notification}/delete', 'Secure\NotificationController@delete');
    Route::resource('notification', 'Secure\NotificationController');

    Route::group(['prefix' => 'feedback'], function () {
        Route::get('data', 'Secure\FeedbackController@data');
        Route::get('{feedback}/delete', 'Secure\FeedbackController@delete');
        Route::get('{feedback}/show', 'Secure\FeedbackController@show');
    }
    );
    Route::resource('feedback', 'Secure\FeedbackController');

    Route::get('report/{user}/forstudent', 'Secure\ReportController@student');
    Route::post('report', 'Secure\ReportController@create');

    Route::get('diary/data', 'Secure\DairyController@data');
    Route::get('diary/export', 'Secure\DairyController@export');
    Route::get('diary/{diary}/download', 'Secure\DairyController@download');
    Route::get('diary/{diary}/show', 'Secure\DairyController@show');
    Route::resource('diary', 'Secure\DairyController');

    Route::group(['prefix' => 'schools'], function () {
        Route::get('data', 'Secure\SchoolController@data');
        Route::get('{school}/edit', 'Secure\SchoolController@edit');
        Route::put('{school}', 'Secure\SchoolController@update');
        Route::get('{school}/delete', 'Secure\SchoolController@delete');
        Route::delete('{school}', 'Secure\SchoolController@destroy');
        Route::get('{school}/show', 'Secure\SchoolController@show');
        Route::get('{school}/activate', 'Secure\SchoolController@activate');
    });
    Route::resource('schools', 'Secure\SchoolController');

    Route::get('visitor_card/{user}', 'Secure\VisitorStudentCardController@visitor');
    Route::get('student_card/{student}', 'Secure\VisitorStudentCardController@student');



    //route for admin users
    Route::group(['middleware' => 'has_any_role:admin_super_admin,super_admin,admin,accountant'], function () {

        Route::group(['prefix' => 'login_history'], function () {
            Route::get('data', 'Secure\LoginHistoryController@data');
        });
        Route::resource('login_history', 'Secure\LoginHistoryController');

        Route::group(['prefix' => 'schoolyear'], function () {
            Route::get('data', 'Secure\SchoolYearController@data');
            Route::put('{schoolYear}', 'Secure\SchoolYearController@update');
            Route::delete('{schoolYear}', 'Secure\SchoolYearController@destroy');
            Route::get('{section}/get_students', 'Secure\SchoolYearController@getStudents');
            Route::get('{schoolYear}/delete', 'Secure\SchoolYearController@delete');
            Route::get('{schoolYear}/edit', 'Secure\SchoolYearController@edit');
            Route::get('{schoolYear}/show', 'Secure\SchoolYearController@show');
            Route::get('{schoolYear}/{school}/get_sections', 'Secure\SchoolYearController@getSections');
            Route::get('{schoolYear}/copy_data', 'Secure\SchoolYearController@copyData');
            Route::post('{schoolYear}/post_data', 'Secure\SchoolYearController@postData');
            Route::get('{schoolYear}/make_alumini', 'Secure\SchoolYearController@makeAlumini');
            Route::get('{schoolYear}/get_alumini', 'Secure\SchoolYearController@getAlumini');
            Route::post('{schoolYear}/post_alumini', 'Secure\SchoolYearController@postAlumini');
            Route::post('{schoolYear}/{alumini}/get_alumini_students', 'Secure\SchoolYearController@getAluminiStudents');
        });
        Route::resource('schoolyear', 'Secure\SchoolYearController');

        Route::group(['prefix' => 'block_login'], function () {
            Route::get('data', 'Secure\BlockLoginController@data');
            Route::delete('{blockLogin}', 'Secure\BlockLoginController@destroy');
            Route::get('{blockLogin}/delete', 'Secure\BlockLoginController@delete');
        });
        Route::resource('block_login', 'Secure\BlockLoginController');

        Route::group(['prefix' => 'subject'], function () {
            Route::get('data', 'Secure\SubjectController@data');
	        Route::get('bulk_delete', 'Secure\SubjectController@bulkDelete');
            Route::get('import', 'Secure\SubjectController@getImport');
            Route::post('import', 'Secure\SubjectController@postImport');
            Route::post('finish_import', 'Secure\SubjectController@finishImport');
            Route::get('download-template', 'Secure\SubjectController@downloadExcelTemplate');
            Route::get('{subject}/delete', 'Secure\SubjectController@delete');
            Route::get('{subject}/show', 'Secure\SubjectController@show');
            Route::get('{subject}/edit', 'Secure\SubjectController@edit');
            Route::get('{subject}/create_invoices', 'Secure\SubjectController@create_invoices');
        });
        Route::resource('subject', 'Secure\SubjectController');

        Route::group(['prefix' => 'holiday'], function () {
            Route::get('data', 'Secure\HolidayController@data');
            Route::get('{holiday}/delete', 'Secure\HolidayController@delete');
            Route::get('{holiday}/show', 'Secure\HolidayController@show');
            Route::get('{holiday}/edit', 'Secure\HolidayController@edit');
            Route::put('{holiday}', 'Secure\HolidayController@update');
        });
        Route::resource('holiday', 'Secure\HolidayController');

        Route::group(['prefix' => 'timetable_period'], function () {
            Route::get('data', 'Secure\TimetablePeriodController@data');
            Route::get('{timetablePeriod}/delete', 'Secure\TimetablePeriodController@delete');
            Route::get('{timetablePeriod}/show', 'Secure\TimetablePeriodController@show');
            Route::get('{timetablePeriod}/edit', 'Secure\TimetablePeriodController@edit');
            Route::put('{timetablePeriod}', 'Secure\TimetablePeriodController@update');
	        Route::get('import', 'Secure\TimetablePeriodController@getImport');
	        Route::post('import', 'Secure\TimetablePeriodController@postImport');
	        Route::post('finish_import', 'Secure\TimetablePeriodController@finishImport');
	        Route::get('download-template', 'Secure\TimetablePeriodController@downloadExcelTemplate');
        });
        Route::resource('timetable_period', 'Secure\TimetablePeriodController');

        Route::group(['prefix' => 'slider'], function () {
            Route::get('data', 'Secure\SliderController@data');
            Route::get('{slider}/delete', 'Secure\SliderController@delete');
            Route::get('{slider}/show', 'Secure\SliderController@show');
            Route::get('{slider}/edit', 'Secure\SliderController@edit');
            Route::put('{slider}', 'Secure\SliderController@update');
            Route::get('reorderSlider', 'Secure\SliderController@reorderSlider');
        });
        Route::resource('slider', 'Secure\SliderController');

        Route::group(['prefix' => 'country'], function () {
            Route::get('data', 'Secure\CountryController@data');
            Route::get('{country}/delete', 'Secure\CountryController@delete');
            Route::get('{country}/show', 'Secure\CountryController@show');
            Route::get('{country}/edit', 'Secure\CountryController@edit');
            Route::put('{country}', 'Secure\CountryController@update');
        });
        Route::resource('country', 'Secure\CountryController');

        Route::group(['prefix' => 'staff_leave_type'], function () {
            Route::get('data', 'Secure\StaffLeaveTypeController@data');
            Route::get('{staffLeaveType}/delete', 'Secure\StaffLeaveTypeController@delete');
            Route::get('{staffLeaveType}/show', 'Secure\StaffLeaveTypeController@show');
            Route::get('{staffLeaveType}/edit', 'Secure\StaffLeaveTypeController@edit');
            Route::put('{staffLeaveType}', 'Secure\StaffLeaveTypeController@update');
        });
        Route::resource('staff_leave_type', 'Secure\StaffLeaveTypeController');

        Route::group(['prefix' => 'sms_message'], function () {
            Route::get('data', 'Secure\SmsMessageController@data');
            Route::get('group_sms', 'Secure\SmsMessageController@group_sms');
            Route::post('store_group', 'Secure\SmsMessageController@store_group');
            Route::get('{smsMessage}/show', 'Secure\SmsMessageController@show');
        });
        Route::resource('sms_message', 'Secure\SmsMessageController');

        Route::group(['prefix' => 'certificate'], function () {
            Route::get('data', 'Secure\CertificateController@data');
            Route::get('{certificate}/delete', 'Secure\CertificateController@delete');
            Route::get('{certificate}/show', 'Secure\CertificateController@show');
            Route::get('{certificate}/edit', 'Secure\CertificateController@edit');
            Route::get('{certificate}/user', 'Secure\CertificateController@user');
            Route::put('{certificate}/addusers', 'Secure\CertificateController@addusers');
        });
        Route::resource('certificate', 'Secure\CertificateController');

        Route::group(['prefix' => 'qualification'], function () {
            Route::get('data', 'Secure\QualificationController@data');
            Route::get('{qualification}/delete', 'Secure\QualificationController@delete');
            Route::get('{qualification}/show', 'Secure\QualificationController@show');
            Route::get('{qualification}/edit', 'Secure\QualificationController@edit');
            Route::get('{qualification}/user', 'Secure\QualificationController@user');
        });
        Route::resource('qualification', 'Secure\QualificationController');

        Route::group(['prefix' => 'religion'], function () {
            Route::get('data', 'Secure\ReligionController@data');
            Route::get('{religion}/delete', 'Secure\ReligionController@delete');
            Route::get('{religion}/show', 'Secure\ReligionController@show');
            Route::get('{religion}/edit', 'Secure\ReligionController@edit');
            Route::get('{religion}/user', 'Secure\ReligionController@user');
        });
        Route::resource('religion', 'Secure\ReligionController');

        Route::group(['prefix' => 'marital_status'], function () {
            Route::get('data', 'Secure\MaritalStatusController@data');
            Route::get('{maritalStatus}/delete', 'Secure\MaritalStatusController@delete');
            Route::get('{maritalStatus}/show', 'Secure\MaritalStatusController@show');
            Route::get('{maritalStatus}/edit', 'Secure\MaritalStatusController@edit');
            Route::get('{maritalStatus}/user', 'Secure\MaritalStatusController@user');
        });
        Route::resource('marital_status', 'Secure\MaritalStatusController');

        Route::group(['prefix' => 'denomination'], function () {
            Route::get('data', 'Secure\DenominationController@data');
            Route::get('{denomination}/delete', 'Secure\DenominationController@delete');
            Route::get('{denomination}/show', 'Secure\DenominationController@show');
            Route::get('{denomination}/edit', 'Secure\DenominationController@edit');
            Route::get('{denomination}/user', 'Secure\DenominationController@user');
        });
        Route::resource('denomination', 'Secure\DenominationController');

        Route::group(['prefix' => 'entry_mode'], function () {
            Route::get('data', 'Secure\EntryModeController@data');
            Route::get('{entryMode}/delete', 'Secure\EntryModeController@delete');
            Route::get('{entryMode}/show', 'Secure\EntryModeController@show');
            Route::get('{entryMode}/edit', 'Secure\EntryModeController@edit');
            Route::get('{entryMode}/user', 'Secure\EntryModeController@user');
        });
        Route::resource('entry_mode', 'Secure\EntryModeController');

        Route::group(['prefix' => 'session'], function () {
            Route::get('data', 'Secure\SessionController@data');
            Route::get('{session}/delete', 'Secure\SessionController@delete');
            Route::get('{session}/show', 'Secure\SessionController@show');
            Route::get('{session}/edit', 'Secure\SessionController@edit');
            Route::get('{session}/user', 'Secure\SessionController@user');
        });
        Route::resource('session', 'Secure\SessionController');

        Route::group(['prefix' => 'intake_period'], function () {
            Route::get('data', 'Secure\IntakePeriodController@data');
            Route::get('{intakePeriod}/delete', 'Secure\IntakePeriodController@delete');
            Route::get('{intakePeriod}/show', 'Secure\IntakePeriodController@show');
            Route::get('{intakePeriod}/edit', 'Secure\IntakePeriodController@edit');
            Route::get('{intakePeriod}/user', 'Secure\IntakePeriodController@user');
        });
        Route::resource('intake_period', 'Secure\IntakePeriodController');

        Route::group(['prefix' => 'fee_period'], function () {
            Route::get('data', 'Secure\FeePeriodController@data');
            Route::get('{feePeriod}/delete', 'Secure\FeePeriodController@delete');
            Route::get('{feePeriod}/show', 'Secure\FeePeriodController@show');
            Route::get('{feePeriod}/edit', 'Secure\FeePeriodController@edit');
            Route::get('{feePeriod}/user', 'Secure\FeePeriodController@user');
        });
        Route::resource('fee_period', 'Secure\FeePeriodController');

        Route::post('student_final_mark/add-final-mark', 'Secure\StudentFinalMarkController@addFinalMark');
        Route::get('student_final_mark/{section}/get-groups', 'Secure\StudentFinalMarkController@getGroups');
        Route::get('student_final_mark/{studentGroup}/get-subjects', 'Secure\StudentFinalMarkController@getSubjects');
        Route::get('student_final_mark/{studentGroup}/{subject}/get-students', 'Secure\StudentFinalMarkController@getStudents');
        Route::resource('student_final_mark', 'Secure\StudentFinalMarkController');

        Route::get('semester/data', 'Secure\SemesterController@data');
        Route::get('semester/{semester}/show', 'Secure\SemesterController@show');
        Route::get('semester/{semester}/edit', 'Secure\SemesterController@edit');
        Route::get('semester/{semester}/delete', 'Secure\SemesterController@delete');
        Route::get('semester/{semester}/active', 'Secure\SemesterController@active');
        Route::resource('semester', 'Secure\SemesterController');

        Route::get('behavior/data', 'Secure\BehaviorController@data');
        Route::get('behavior/{behavior}/show', 'Secure\BehaviorController@show');
        Route::get('behavior/{behavior}/edit', 'Secure\BehaviorController@edit');
        Route::get('behavior/{behavior}/delete', 'Secure\BehaviorController@delete');
        Route::resource('behavior', 'Secure\BehaviorController');

        Route::get('dormitory/data', 'Secure\DormitoryController@data');
        Route::get('dormitory/{dormitory}/show', 'Secure\DormitoryController@show');
        Route::get('dormitory/{dormitory}/edit', 'Secure\DormitoryController@edit');
        Route::get('dormitory/{dormitory}/delete', 'Secure\DormitoryController@delete');
        Route::resource('dormitory', 'Secure\DormitoryController');

        Route::get('dormitoryroom/data', 'Secure\DormitoryRoomController@data');
        Route::put('dormitoryroom/{dormitoryRoom}', 'Secure\DormitoryRoomController@update');
        Route::delete('dormitoryroom/{dormitoryRoom}', 'Secure\DormitoryRoomController@destroy');
        Route::get('dormitoryroom/{dormitoryRoom}/show', 'Secure\DormitoryRoomController@show');
        Route::get('dormitoryroom/{dormitoryRoom}/edit', 'Secure\DormitoryRoomController@edit');
        Route::get('dormitoryroom/{dormitoryRoom}/delete', 'Secure\DormitoryRoomController@delete');
        Route::resource('dormitoryroom', 'Secure\DormitoryRoomController');

        Route::get('dormitorybed/data', 'Secure\DormitoryBedController@data');
        Route::put('dormitorybed/{dormitoryBed}', 'Secure\DormitoryBedController@update');
        Route::delete('dormitorybed/{dormitoryBed}', 'Secure\DormitoryBedController@destroy');
        Route::put('dormitorybed/{dormitoryBed}', 'Secure\DormitoryBedController@update');
        Route::delete('dormitorybed/{dormitoryBed}', 'Secure\DormitoryBedController@destroy');
        Route::get('dormitorybed/{dormitoryBed}/show', 'Secure\DormitoryBedController@show');
        Route::get('dormitorybed/{dormitoryBed}/edit', 'Secure\DormitoryBedController@edit');
        Route::get('dormitorybed/{dormitoryBed}/delete', 'Secure\DormitoryBedController@delete');
        Route::resource('dormitorybed', 'Secure\DormitoryBedController');

	    Route::group(['prefix' => 'markvalue'], function () {
		    Route::get( 'data', 'Secure\MarkValueController@data' );
		    Route::put( '{markValue}', 'Secure\MarkValueController@update' );
		    Route::delete( '{markValue}', 'Secure\MarkValueController@destroy' );
		    Route::get( 'markvue/{markValue}/show', 'Secure\MarkValueController@show' );
		    Route::get( '{markValue}/edit', 'Secure\MarkValueController@edit' );
		    Route::get( '{markValue}/delete', 'Secure\MarkValueController@delete' );
		    Route::get( 'import', 'Secure\MarkValueController@getImport' );
		    Route::post( 'import', 'Secure\MarkValueController@postImport' );
		    Route::post( 'finish_import', 'Secure\MarkValueController@finishImport' );
		    Route::get( 'download-template', 'Secure\MarkValueController@downloadExcelTemplate' );
	    });
        Route::resource('markvalue', 'Secure\MarkValueController');

        Route::get('marksystem/data', 'Secure\MarkSystemController@data');
        Route::put('marksystem/{markSystem}', 'Secure\MarkSystemController@update');
        Route::delete('marksystem/{markSystem}', 'Secure\MarkSystemController@destroy');
        Route::get('marksystem/{markSystem}/show', 'Secure\MarkSystemController@show');
        Route::get('marksystem/{markSystem}/edit', 'Secure\MarkSystemController@edit');
        Route::get('marksystem/{markSystem}/delete', 'Secure\MarkSystemController@delete');
        Route::resource('marksystem', 'Secure\MarkSystemController');

        Route::get('marktype/data', 'Secure\MarkTypeController@data');
        Route::put('marktype/{markType}', 'Secure\MarkTypeController@update');
        Route::delete('marktype/{markType}', 'Secure\MarkTypeController@destroy');
        Route::get('marktype/{markType}/show', 'Secure\MarkTypeController@show');
        Route::get('marktype/{markType}/edit', 'Secure\MarkTypeController@edit');
        Route::get('marktype/{markType}/delete', 'Secure\MarkTypeController@delete');
        Route::resource('marktype', 'Secure\MarkTypeController');

        Route::get('noticetype/data', 'Secure\NoticeTypeController@data');
        Route::put('noticetype/{noticeType}', 'Secure\NoticeTypeController@update');
        Route::delete('noticetype/{noticeType}', 'Secure\NoticeTypeController@destroy');
        Route::get('noticetype/{noticeType}/show', 'Secure\NoticeTypeController@show');
        Route::get('noticetype/{noticeType}/edit', 'Secure\NoticeTypeController@edit');
        Route::get('noticetype/{noticeType}/delete', 'Secure\NoticeTypeController@delete');
        Route::resource('noticetype', 'Secure\NoticeTypeController');

        Route::get('setting', 'Secure\SettingController@index');
        Route::post('setting', 'Secure\SettingController@store');
        Route::get('setting/get_theme_colors/{theme}', 'Secure\SettingController@getThemeColors');

        Route::group(['prefix' => 'option'], function () {
            Route::get('data/{slug2}', 'Secure\OptionController@data');
            Route::get('data', 'Secure\OptionController@data');
            Route::get('{option}/show', 'Secure\OptionController@show');
            Route::get('{option}/delete', 'Secure\OptionController@delete');
        });
        Route::resource('option', 'Secure\OptionController');

        Route::get('department/data', 'Secure\DepartmentController@data');
        Route::get('department/{department}/show', 'Secure\DepartmentController@show');
        Route::get('department/{department}/edit', 'Secure\DepartmentController@edit');
        Route::get('department/{department}/delete', 'Secure\DepartmentController@delete');
        Route::resource('department', 'Secure\DepartmentController');

        Route::get('direction/data', 'Secure\DirectionController@data');
        Route::get('direction/{direction}/show', 'Secure\DirectionController@show');
        Route::get('direction/{direction}/edit', 'Secure\DirectionController@edit');
        Route::get('direction/{direction}/delete', 'Secure\DirectionController@delete');
        Route::resource('direction', 'Secure\DirectionController');

        Route::get('section/data', 'Secure\SectionController@data');
        Route::get('section/{section}/show', 'Secure\SectionController@show');
        Route::get('section/{section}/edit', 'Secure\SectionController@edit');
        Route::get('section/{section}/delete', 'Secure\SectionController@delete');
        Route::get('section/{section}/students', 'Secure\SectionController@students');
        Route::get('section/{section}/studentsdata', 'Secure\SectionController@students_data');
        Route::get('section/{section}/generate_csv', 'Secure\SectionController@generateCsvStudentsSection');
        Route::get('section/{section}/groups', 'Secure\SectionController@groups');
        Route::get('section/{section}/get_groups', 'Secure\SectionController@get_groups');
        Route::get('section/{section}/groupsdata', 'Secure\SectionController@groups_data');
        Route::get('section/{section}/make_invoices', 'Secure\SectionController@make_invoices');
        Route::get('section/{section}/generate_code', 'Secure\SectionController@generate_code');
        Route::resource('section', 'Secure\SectionController');

        Route::group(['prefix' => 'school_admin'], function () {
            Route::get('data', 'Secure\SchoolAdminController@data');
            Route::get('{school_admin}/edit', 'Secure\SchoolAdminController@edit');
            Route::get('{school_admin}/delete', 'Secure\SchoolAdminController@delete');
            Route::get('{school_admin}/show', 'Secure\SchoolAdminController@show');
        });
        Route::resource('school_admin', 'Secure\SchoolAdminController');

        Route::group(['prefix' => 'school_direction'], function () {
            Route::get('data', 'Secure\SchoolDirectionController@data');
            Route::put('{schoolDirection}', 'Secure\SchoolDirectionController@update');
            Route::delete('{schoolDirection}', 'Secure\SchoolDirectionController@destroy');
            Route::get('{schoolDirection}/edit', 'Secure\SchoolDirectionController@edit');
            Route::get('{schoolDirection}/delete', 'Secure\SchoolDirectionController@delete');
            Route::get('{schoolDirection}/show', 'Secure\SchoolDirectionController@show');
        });
        Route::resource('school_direction', 'Secure\SchoolDirectionController');

        Route::group(['prefix' => 'studentgroup'], function () {
            Route::get('{section}/create', 'Secure\StudentGroupController@create');
            Route::get('duration', 'Secure\StudentGroupController@getDuration');
            Route::put('{studentGroup}', 'Secure\StudentGroupController@update');
            Route::get('{studentGroup}/generate_csv', 'Secure\SectionController@generateCsvStudentsGroup');
            Route::get('{section}/{studentGroup}/show', 'Secure\StudentGroupController@show');
            Route::get('{section}/{studentGroup}/edit', 'Secure\StudentGroupController@edit');
            Route::get('{section}/{studentGroup}/delete', 'Secure\StudentGroupController@delete');
            Route::delete('{section}/{studentGroup}', 'Secure\StudentGroupController@destroy');
            Route::get('{section}/{studentGroup}/students', 'Secure\StudentGroupController@students');
            Route::put('{section}/{studentGroup}/addstudents', 'Secure\StudentGroupController@addstudents');
            Route::get('{section}/{studentGroup}/subjects', 'Secure\StudentGroupController@subjects');
            Route::put('{subject}/{studentGroup}/addeditsubject', 'Secure\StudentGroupController@addeditsubject');
            Route::get('{section}/{studentGroup}/timetable', 'Secure\StudentGroupController@timetable');
            Route::get('{section}/{studentGroup}/{semester_id?}/print_timetable', 'Secure\StudentGroupController@print_timetable');
            Route::post('{section}/{studentGroup}/addtimetable', 'Secure\StudentGroupController@addtimetable');
            Route::delete('{section}/{studentGroup}/deletetimetable', 'Secure\StudentGroupController@deletetimetable');
        });
        Route::resource('studentgroup', 'Secure\StudentGroupController');

        Route::group(['prefix' => 'scholarship'], function () {
            Route::get('data', 'Secure\ScholarshipController@data');
            Route::get('{scholarship}/delete', 'Secure\ScholarshipController@delete');
            Route::get('{scholarship}/show', 'Secure\ScholarshipController@show');
            Route::get('{scholarship}/edit', 'Secure\ScholarshipController@edit');
        });
        Route::resource('scholarship', 'Secure\ScholarshipController');

        Route::get('fee_category/data', 'Secure\FeeCategoryController@data');
        Route::put('fee_category/{feeCategory}', 'Secure\FeeCategoryController@update');
        Route::delete('fee_category/{feeCategory}', 'Secure\FeeCategoryController@destroy');
        Route::get('fee_category/{feeCategory}/show', 'Secure\FeeCategoryController@show');
        Route::get('fee_category/{feeCategory}/edit', 'Secure\FeeCategoryController@edit');
        Route::get('fee_category/{feeCategory}/delete', 'Secure\FeeCategoryController@delete');
        Route::resource('fee_category', 'Secure\FeeCategoryController');

        Route::group(['prefix' => 'custom_user_field'], function () {
            Route::get('data', 'Secure\CustomUserFieldController@data');
            Route::get('{customUserField}/delete', 'Secure\CustomUserFieldController@delete');
            Route::get('{customUserField}/show', 'Secure\CustomUserFieldController@show');
            Route::get('{customUserField}/edit', 'Secure\CustomUserFieldController@edit');
            Route::delete('{customUserField}', 'Secure\CustomUserFieldController@destroy');
            Route::put('{customUserField}', 'Secure\CustomUserFieldController@update');
        });
        Route::resource('custom_user_field', 'Secure\CustomUserFieldController');

        Route::group(['prefix' => 'blog_category'], function () {
            Route::get('data', 'Secure\BlogCategoryController@data');
            Route::get('{blogCategory}/delete', 'Secure\BlogCategoryController@delete');
            Route::get('{blogCategory}/show', 'Secure\BlogCategoryController@show');
            Route::get('{blogCategory}/edit', 'Secure\BlogCategoryController@edit');
            Route::delete('{blogCategory}', 'Secure\BlogCategoryController@destroy');
            Route::put('{blogCategory}', 'Secure\BlogCategoryController@update');
        });
        Route::resource('blog_category', 'Secure\BlogCategoryController');

        Route::group(['prefix' => 'blog'], function () {
            Route::get('data', 'Secure\BlogController@data');
            Route::get('{blog}/delete', 'Secure\BlogController@delete');
            Route::get('{blog}/show', 'Secure\BlogController@show');
            Route::get('{blog}/edit', 'Secure\BlogController@edit');
            Route::delete('{blog}', 'Secure\BlogController@destroy');
            Route::put('{blog}', 'Secure\BlogController@update');
        });
        Route::resource('blog', 'Secure\BlogController');

        Route::group(['prefix' => 'faq_category'], function () {
            Route::get('data', 'Secure\FaqCategoryController@data');
            Route::get('{faqCategory}/delete', 'Secure\FaqCategoryController@delete');
            Route::get('{faqCategory}/show', 'Secure\FaqCategoryController@show');
            Route::get('{faqCategory}/edit', 'Secure\FaqCategoryController@edit');
            Route::delete('{faqCategory}', 'Secure\FaqCategoryController@destroy');
            Route::put('{faqCategory}', 'Secure\FaqCategoryController@update');
        });
        Route::resource('faq_category', 'Secure\FaqCategoryController');

        Route::group(['prefix' => 'faq'], function () {
            Route::get('data', 'Secure\FaqController@data');
            Route::get('{faq}/delete', 'Secure\FaqController@delete');
            Route::get('{faq}/show', 'Secure\FaqController@show');
            Route::get('{faq}/edit', 'Secure\FaqController@edit');
            Route::delete('{faq}', 'Secure\FaqController@destroy');
            Route::put('{faq}', 'Secure\FaqController@update');
        });
        Route::resource('faq', 'Secure\FaqController');

    });

	Route::group(['middleware' => 'has_any_role:admin,admin_super_admin,doorman'], function () {
		Route::group( [ 'prefix' => 'visitor' ], function () {
			Route::delete( '{visitor}', 'Secure\VisitorController@destroy' );
			Route::get( 'data', 'Secure\VisitorController@data' );
			Route::get( '{visitor}/show', 'Secure\VisitorController@show' );
			Route::get( '{visitor}/delete', 'Secure\VisitorController@delete' );
			Route::get('{visitor}/edit', 'Secure\VisitorController@edit');
		} );
		Route::resource( 'visitor', 'Secure\VisitorController' );
	});


    Route::group(['middleware' => 'has_any_role:admin,admin_super_admin,doorman'], function () {
        Route::group( [ 'prefix' => 'applicant' ], function () {
            Route::get('data/{first_name?}/{last_name?}/{applicant_id?}/{country_id?}/{direction_id?}/{session_id?}/{section_id?}/{level_id?}/{entry_mode_id?}/{gender?}/{marital_id?}/{dormitory_id?}', 'Secure\ApplicantController@data');
            Route::delete( '{applicant}', 'Secure\ApplicantController@destroy' );
	        Route::get( '{applicant}/show', 'Secure\ApplicantController@show' );
            Route::get( '{applicant}/delete', 'Secure\ApplicantController@delete' );
            Route::get('{applicant}/edit', 'Secure\ApplicantController@edit');
            Route::get('{applicant}/move_to_student', 'Secure\ApplicantController@moveToStudent');
        } );
        Route::resource( 'applicant', 'Secure\ApplicantController' );
    });

    //****************routes for applicant users*******************************
    Route::group(['middleware' => 'has_any_role:applicant'], function () {
        Route::get('applicant_personal/', 'Secure\ApplicantController@personal');

        Route::group( [ 'prefix' => 'applicant_work' ], function () {
            Route::delete( '{applicantWork}', 'Secure\ApplicantWorkController@destroy' );
            Route::get( 'data', 'Secure\ApplicantWorkController@data' );
            Route::get( '{applicantWork}/show', 'Secure\ApplicantWorkController@show' );
            Route::get( '{applicantWork}/delete', 'Secure\ApplicantWorkController@delete' );
            Route::get('{applicantWork}/edit', 'Secure\ApplicantWorkController@edit');
        } );
        Route::resource( 'applicant_work', 'Secure\ApplicantWorkController' );
    });

	Route::group(['middleware' => 'has_any_role:admin,admin_super_admin,super_admin'], function () {
		Route::group( [ 'prefix' => 'all_mails' ], function () {
			Route::get('/', 'Secure\AdminUserMailsController@index');
			Route::post('/mails', 'Secure\AdminUserMailsController@getMails');
		} );
	});

	Route::group(['middleware' => 'has_any_role:admin,admin_super_admin'], function () {
		Route::group( [ 'prefix' => 'transportation' ], function () {
			Route::get('{transportation}/edit', 'Secure\TransportationController@edit');
			Route::get('{transportation}/delete', 'Secure\TransportationController@delete');
		} );
	});

	Route::group(['middleware' => 'has_any_role:admin,admin_super_admin,teacher,student,parent'], function () {
		Route::group( [ 'prefix' => 'transportation' ], function () {
			Route::get('data', 'Secure\TransportationController@data');
			Route::get('{transportation}/show', 'Secure\TransportationController@show');
		} );
		Route::resource('transportation', 'Secure\TransportationController');
	});

	Route::group(['middleware' => 'has_any_role:doorman'], function () {
		Route::group( [ 'prefix' => 'visitor_visit' ], function () {
			Route::get( 'data', 'Secure\VisitorVisitController@data' );
			Route::get('{visitorLog}/edit', 'Secure\VisitorVisitController@edit');
			Route::get('{visitorLog}/show', 'Secure\VisitorVisitController@show' );
		} );
		Route::resource( 'visitor_visit', 'Secure\VisitorVisitController' );
	});

    Route::group(['middleware' => 'has_any_role:admin,admin_super_admin'], function () {
        Route::get('student_attendances_admin', 'Secure\StudentAttendanceAdminController@index');
        Route::post('student_attendances_admin/attendance', 'Secure\StudentAttendanceAdminController@attendance');
        Route::post('student_attendances_admin/attendanceAjax', 'Secure\StudentAttendanceAdminController@attendanceAjax');

        Route::get('attendances_by_subject', 'Secure\StudentAttendanceAdminBySubjectController@index');
        Route::post('attendances_by_subject/get_groups', 'Secure\StudentAttendanceAdminBySubjectController@getGroups');
        Route::post('attendances_by_subject/get_students', 'Secure\StudentAttendanceAdminBySubjectController@getStudents');
        Route::post('attendances_by_subject/attendance_graph', 'Secure\StudentAttendanceAdminBySubjectController@attendanceGraph');

        Route::get('admin_exam', 'Secure\AdminExamController@index');
        Route::get('admin_exam/create_by_group', 'Secure\AdminExamController@create_by_group');
        Route::get('admin_exam/create_by_subject', 'Secure\AdminExamController@create_by_subject');
	    Route::get('admin_exam/{studentGroup}/subjects', 'Secure\AdminExamController@subjects');
        Route::post('admin_exam/store_by_group', 'Secure\AdminExamController@store_by_group');
        Route::post('admin_exam/store_by_subject', 'Secure\AdminExamController@store_by_subject');
	    Route::get('admin_exam/data', 'Secure\AdminExamController@data');
	    Route::get('admin_exam/{exam}/show', 'Secure\AdminExamController@show');

    });


    Route::group(['middleware' => 'has_any_role:admin,super_admin,librarian,admin_super_admin'], function () {

        Route::get('task', 'Secure\TaskController@index');
        Route::post('task/create', 'Secure\TaskController@store');
        Route::get('task/data', 'Secure\TaskController@data');
        Route::post('task/{task}/edit', 'Secure\TaskController@update');
        Route::post('task/{task}/delete', 'Secure\TaskController@delete');

    });
    Route::group(['middleware' => 'has_any_role:accountant,librarian'], function () {
        Route::get('return_book_penalty', 'Secure\ReturnBookPenaltyController@index');
        Route::get('return_book_penalty/data', 'Secure\ReturnBookPenaltyController@data');
    });

    Route::group(['middleware' => 'has_any_role:human_resources,admin,super_admin,accountant,admin_super_admin'], function () {

        Route::group(['prefix' => 'teacher'], function () {
            Route::get('data', 'Secure\TeacherController@data');
            Route::get('import', 'Secure\TeacherController@getImport');
            Route::post('import', 'Secure\TeacherController@postImport');
	        Route::post('finish_import', 'Secure\TeacherController@finishImport');
            Route::get('download-template', 'Secure\TeacherController@downloadExcelTemplate');
	        Route::get('export', 'Secure\TeacherController@export');
            Route::get('get_exists', 'Secure\TeacherController@getExists');
            Route::delete('{teacher_user}', 'Secure\TeacherController@destroy');
            Route::put('{teacher_user}', 'Secure\TeacherController@update');
            Route::get('{teacher_user}/show', 'Secure\TeacherController@show');
            Route::get('{teacher_user}/edit', 'Secure\TeacherController@edit');
            Route::get('{teacher_user}/delete', 'Secure\TeacherController@delete');
        });
        Route::resource('teacher', 'Secure\TeacherController');

        Route::group(['prefix' => 'join_date/{teacher_user}'], function () {
            Route::get('', 'Secure\JoinDateController@index');
            Route::post('', 'Secure\JoinDateController@store');
            Route::get('create', 'Secure\JoinDateController@create');
            Route::get('data', 'Secure\JoinDateController@data');
            Route::delete('{joinDate}', 'Secure\JoinDateController@destroy');
            Route::put('{joinDate}', 'Secure\JoinDateController@update');
            Route::get('{joinDate}/show', 'Secure\JoinDateController@show');
            Route::get('{joinDate}/edit', 'Secure\JoinDateController@edit');
            Route::get('{joinDate}/delete', 'Secure\JoinDateController@delete');
        });

        Route::group(['prefix' => 'staff_salary/{teacher_user}'], function () {
            Route::get('', 'Secure\StaffSalaryController@index');
            Route::post('', 'Secure\StaffSalaryController@store');
            Route::get('create', 'Secure\StaffSalaryController@create');
            Route::get('data', 'Secure\StaffSalaryController@data');
            Route::delete('{staffSalary}', 'Secure\StaffSalaryController@destroy');
            Route::put('{staffSalary}', 'Secure\StaffSalaryController@update');
            Route::get('{staffSalary}/show', 'Secure\StaffSalaryController@show');
            Route::get('{staffSalary}/edit', 'Secure\StaffSalaryController@edit');
            Route::get('{staffSalary}/delete', 'Secure\StaffSalaryController@delete');
        });

        Route::get('librarian/data', 'Secure\LibrarianController@data');
        Route::get('librarian/{librarian_user}/show', 'Secure\LibrarianController@show');
        Route::get('librarian/{librarian_user}/edit', 'Secure\LibrarianController@edit');
        Route::get('librarian/{librarian_user}/delete', 'Secure\LibrarianController@delete');
        Route::resource('librarian', 'Secure\LibrarianController');

        Route::get('doorman/data', 'Secure\DoormanController@data');
        Route::get('doorman/{doorman_user}/show', 'Secure\DoormanController@show');
        Route::get('doorman/{doorman_user}/edit', 'Secure\DoormanController@edit');
        Route::get('doorman/{doorman_user}/delete', 'Secure\DoormanController@delete');
        Route::resource('doorman', 'Secure\DoormanController');


        Route::group(['prefix' => 'account'], function () {
            Route::get('data', 'Secure\AccountController@data');
            Route::get('{account}/edit', 'Secure\AccountController@edit');
            Route::get('{account}/delete', 'Secure\AccountController@delete');
            Route::get('{account}/show', 'Secure\AccountController@show');});
        Route::resource('account', 'Secure\AccountController');

        Route::get('account_type/data', 'Secure\AccountTypeController@data');
        Route::get('account_type/{accountType}/show', 'Secure\AccountTypeController@show');
        Route::get('account_type/{accountType}/edit', 'Secure\AccountTypeController@edit');
        Route::get('account_type/{accountType}/delete', 'Secure\AccountTypeController@delete');
        Route::resource('account_type', 'Secure\AccountTypeController');

        Route::get('voucher/data', 'Secure\VoucherController@data');
        Route::get('voucher/{voucher}/show', 'Secure\VoucherController@show');
        Route::get('voucher/{voucher}/edit', 'Secure\VoucherController@edit');
        Route::get('voucher/{voucher}/delete', 'Secure\VoucherController@delete');
        Route::resource('voucher', 'Secure\VoucherController');

        Route::group(['prefix' => 'salary'], function () {
            Route::get('data', 'Secure\SalaryController@data');
            Route::get('{salary}/delete', 'Secure\SalaryController@delete');
            Route::get('{salary}/show', 'Secure\SalaryController@show');
            Route::get('{salary}/edit', 'Secure\SalaryController@edit');
            Route::get('{salary}/print_salary', 'Secure\SalaryController@print_salary');
        });
        Route::resource('salary', 'Secure\SalaryController');

        Route::group(['prefix' => 'staff_attendance'], function () {
            Route::post('attendance', 'Secure\StaffAttendanceController@attendanceForDate');
            Route::post('delete', 'Secure\StaffAttendanceController@deleteattendance');
            Route::post('add', 'Secure\StaffAttendanceController@addAttendance');
        });
        Route::resource('staff_attendance', 'Secure\StaffAttendanceController');

	    Route::get( 'staff_leave/{staffLeave}/approve', 'Secure\StaffLeaveController@approveLeave' );
	    Route::get( 'staff_leave/{staffLeave}/no_approve', 'Secure\StaffLeaveController@noApproveLeave' );

        Route::get('invoice/data', 'Secure\InvoiceController@data');
        Route::get('invoice/{invoice}/show', 'Secure\InvoiceController@show');
        Route::get('invoice/{invoice}/edit', 'Secure\InvoiceController@edit');
        Route::get('invoice/{invoice}/delete', 'Secure\InvoiceController@delete');
        Route::resource('invoice', 'Secure\InvoiceController');

        Route::get('registration/data', 'Secure\RegistrationController@data');
        Route::get('registration/{studentGroup}/subjects_students', 'Secure\RegistrationController@subjectsStudents');
        Route::get('registration/{registration}/show', 'Secure\RegistrationController@show');
        Route::get('registration/{registration}/edit', 'Secure\RegistrationController@edit');
        Route::get('registration/{registration}/delete', 'Secure\RegistrationController@delete');
        Route::resource('registration', 'Secure\RegistrationController');

        Route::get('levels/data', 'Secure\LevelController@data');
        Route::get('levels/{level}/show', 'Secure\LevelController@show');
        Route::get('levels/{level}/edit', 'Secure\LevelController@edit');
        Route::get('levels/{level}/delete', 'Secure\LevelController@delete');
        Route::resource('levels', 'Secure\LevelController');

        Route::get('debtor/data', 'Secure\DebtorController@data');
        Route::get('debtor/{user}/show', 'Secure\DebtorController@show');
        Route::resource('debtor', 'Secure\DebtorController');

        Route::get('payment/data', 'Secure\PaymentController@data');
        Route::get('payment/{payment}/show', 'Secure\PaymentController@show');
        Route::get('payment/{payment}/edit', 'Secure\PaymentController@edit');
        Route::get('payment/{payment}/delete', 'Secure\PaymentController@delete');
        Route::resource('payment', 'Secure\PaymentController');
    });

	Route::group(['middleware' => 'has_any_role:teacher,student'], function () {
		Route::get('subject_question', 'Secure\SubjectQuestionController@index');
		Route::post('subject_question', 'Secure\SubjectQuestionController@store');
		Route::get('subject_question/create', 'Secure\SubjectQuestionController@create');
		Route::get('subject_question/data/{subject}', 'Secure\SubjectQuestionController@data');
		Route::get('subject_question/data', 'Secure\SubjectQuestionController@data');
		Route::get('subject_question/{subjectQuestion}/show', 'Secure\SubjectQuestionController@show');
		Route::post('subject_question/{subjectQuestion}/replay', 'Secure\SubjectQuestionController@replay');
	});

    Route::group(['middleware' => 'has_any_role:human_resources,admin,super_admin,admin_super_admin'], function () {
        Route::group(['prefix' => 'student'], function () {
            Route::get('data/{first_name?}/{last_name?}/{student_no?}/{country_id?}/{session_id?}/{section_id?}/{level_id?}/{entry_mode_id?}/{gender?}/{marital_status_id?}/{dormitory_id?}', 'Secure\StudentController@data');
            Route::get('import', 'Secure\StudentController@getImport');
            Route::post('import', 'Secure\StudentController@postImport');
	        Route::post('finish_import', 'Secure\StudentController@finishImport');
            Route::get('download-template', 'Secure\StudentController@downloadExcelTemplate');
	        Route::get('export', 'Secure\StudentController@export');
	        Route::get('{session}/sections', 'Secure\StudentController@getSectionBySession');
	        Route::get('{section}/levels', 'Secure\StudentController@getLevelsBySection');
            Route::get('{student}/delete', 'Secure\StudentController@delete');
            Route::delete('{student}', 'Secure\StudentController@destroy');
            Route::get('{student}/show', 'Secure\StudentController@show');
            Route::get('{student}/new_student_no', 'Secure\StudentController@newStudentNo');
        });
        Route::resource('student', 'Secure\StudentController');

        Route::group(['prefix' => 'parent'], function () {
            Route::get('data', 'Secure\ParentController@data');
	        Route::get('import', 'Secure\ParentController@getImport');
	        Route::post('import', 'Secure\ParentController@postImport');
	        Route::post('finish_import', 'Secure\ParentController@finishImport');
	        Route::get('download-template', 'Secure\ParentController@downloadExcelTemplate');
	        Route::get('export', 'Secure\ParentController@export');
            Route::get('{parent_user}/edit', 'Secure\ParentController@edit');
            Route::get('{parent_user}/delete', 'Secure\ParentController@delete');
            Route::get('{parent_user}/show', 'Secure\ParentController@show');
            Route::put('{parent_user}', 'Secure\ParentController@update');
            Route::delete('{parent_user}', 'Secure\ParentController@destroy');
        });
        Route::resource('parent', 'Secure\ParentController');

        Route::group(['prefix' => 'human_resource'], function () {
            Route::get('data', 'Secure\HumanResourceController@data');
            Route::get('{human_resource}/edit', 'Secure\HumanResourceController@edit');
            Route::get('{human_resource}/delete', 'Secure\HumanResourceController@delete');
            Route::get('{human_resource}/show', 'Secure\HumanResourceController@show');});
        Route::resource('human_resource', 'Secure\HumanResourceController');

        Route::group(['prefix' => 'accountant'], function () {
            Route::get('data', 'Secure\AccountantController@data');
            Route::get('{accountant}/edit', 'Secure\AccountantController@edit');
            Route::get('{accountant}/delete', 'Secure\AccountantController@delete');
            Route::get('{accountant}/show', 'Secure\AccountantController@show');});
        Route::resource('accountant', 'Secure\AccountantController');

	    Route::group(['prefix' => 'supplier'], function () {
		    Route::get('data', 'Secure\SupplierController@data');
		    Route::get('{supplier}/edit', 'Secure\SupplierController@edit');
		    Route::get('{supplier}/delete', 'Secure\SupplierController@delete');
		    Route::get('{supplier}/show', 'Secure\SupplierController@show');});
	    Route::resource('supplier', 'Secure\SupplierController');

	    Route::group(['prefix' => 'kitchen_admin'], function () {
		    Route::get('data', 'Secure\KitchenAdminController@data');
		    Route::get('{kitchen_admin}/edit', 'Secure\KitchenAdminController@edit');
		    Route::get('{kitchen_admin}/delete', 'Secure\KitchenAdminController@delete');
		    Route::get('{kitchen_admin}/show', 'Secure\KitchenAdminController@show');});
	    Route::resource('kitchen_admin', 'Secure\KitchenAdminController');

	    Route::group(['prefix' => 'teacher_duty'], function () {
		    Route::get('data', 'Secure\TeacherDutyController@data');
		    Route::put('{teacherDuty}', 'Secure\TeacherDutyController@update');
		    Route::delete('{teacherDuty}', 'Secure\TeacherDutyController@destroy');
		    Route::get('{teacherDuty}/edit', 'Secure\TeacherDutyController@edit');
		    Route::get('{teacherDuty}/delete', 'Secure\TeacherDutyController@delete');
		    Route::get('{teacherDuty}/show', 'Secure\TeacherDutyController@show');});
	    Route::resource('teacher_duty', 'Secure\TeacherDutyController');
	    
    });

	Route::group(['middleware' => 'has_any_role:kitchen_admin,admin,admin_super_admin,super_admin'], function () {

		Route::group(['prefix' => 'kitchen_staff'], function () {
			Route::get('data', 'Secure\KitchenStaffController@data');
			Route::get('{kitchen_staff}/edit', 'Secure\KitchenStaffController@edit');
			Route::get('{kitchen_staff}/delete', 'Secure\KitchenStaffController@delete');
			Route::get('{kitchen_staff}/show', 'Secure\KitchenStaffController@show');});
		Route::resource('kitchen_staff', 'Secure\KitchenStaffController');

		Route::group(['prefix' => 'meal_type'], function () {
			Route::get('data', 'Secure\MealTypeController@data');
			Route::put('{mealType}', 'Secure\MealTypeController@update');
			Route::delete('{mealType}', 'Secure\MealTypeController@destroy');
			Route::get('{mealType}/edit', 'Secure\MealTypeController@edit');
			Route::get('{mealType}/delete', 'Secure\MealTypeController@delete');
			Route::get('{mealType}/show', 'Secure\MealTypeController@show');});
		Route::resource('meal_type', 'Secure\MealTypeController');
	});
	Route::group(['middleware' => 'has_any_role:super_admin,admin,admin_super_admin,teacher,student,parent,human_resources,librarian,accountant,kitchen_admin,kitchen_staff'], function () {

		Route::get('meal_table', 'Secure\MealController@mealTable');
		Route::get('teacher_duty_table', 'Secure\TeacherDutyController@teacherDutyTable');
	});

	Route::group(['middleware' => 'has_any_role:kitchen_admin,kitchen_staff,admin,admin_super_admin'], function () {

		Route::group(['prefix' => 'meal'], function () {
			Route::get('data', 'Secure\MealController@data');
			Route::put('{meal}', 'Secure\MealController@update');
			Route::delete('{meal}', 'Secure\MealController@destroy');
			Route::get('{meal}/edit', 'Secure\MealController@edit');
			Route::get('{meal}/delete', 'Secure\MealController@delete');
			Route::get('{meal}/show', 'Secure\MealController@show');});
		Route::resource('meal', 'Secure\MealController');
	});

    Route::group(['middleware' => 'has_any_role:teacher,student,parent'], function () {

        Route::get('bookuser/index', 'Secure\BookUserController@index');
        Route::get('bookuser/data', 'Secure\BookUserController@data');
        Route::get('bookuser/{book}/reserve', 'Secure\BookUserController@reserve');

        Route::get('borrowedbook/index', 'Secure\BorrowedBookController@index');
        Route::get('borrowedbook/data', 'Secure\BorrowedBookController@data');

        Route::get('report/{user}/subjectbook', 'Secure\ReportController@subjectBook');
        Route::get('report/{user}/getSubjectBook', 'Secure\ReportController@getSubjectBook');

    });

    //route for teacher and admin users
    Route::group(['middleware' => 'has_any_role:teacher,admin,admin_super_admin'], function () {
        Route::get('notice/data', 'Secure\NoticeController@data');
        Route::get('notice/{notice}/show', 'Secure\NoticeController@show');
        Route::get('notice/{notice}/edit', 'Secure\NoticeController@edit');
        Route::get('notice/{notice}/delete', 'Secure\NoticeController@delete');
        Route::get('notice/{notice}/download', 'Secure\NoticeController@download');
        Route::resource('notice', 'Secure\NoticeController');
    });

    //route for teacher and parent users
    Route::group(['middleware' => 'has_any_role:teacher,parent'], function () {
        Route::get('applyingleave/data', 'Secure\ApplyingLeaveController@data');
        Route::put('applyingleave/{applyingLeave}', 'Secure\ApplyingLeaveController@update');
        Route::delete('applyingleave/{applyingLeave}', 'Secure\ApplyingLeaveController@destroy');
        Route::get('applyingleave/{applyingLeave}/edit', 'Secure\ApplyingLeaveController@edit');
        Route::get('applyingleave/{applyingLeave}/delete', 'Secure\ApplyingLeaveController@delete');
        Route::get('applyingleave/{applyingLeave}/show', 'Secure\ApplyingLeaveController@show');
        Route::resource('applyingleave', 'Secure\ApplyingLeaveController');
    });

    Route::group(['middleware' => 'has_any_role:teacher,parent,student'], function () {
        Route::get('study_material/data', 'Secure\StudyMaterialController@data');
        Route::get('study_material/data/{subject}', 'Secure\StudyMaterialController@data');
        Route::put('study_material/{studyMaterial}', 'Secure\StudyMaterialController@update');
        Route::delete('study_material/{studyMaterial}', 'Secure\StudyMaterialController@destroy');
        Route::get('study_material/{studyMaterial}/download', 'Secure\StudyMaterialController@download');
        Route::get('study_material/{subject}/subject', 'Secure\StudyMaterialController@subject');
        Route::get('study_material/{studyMaterial}/show', 'Secure\StudyMaterialController@show');
        Route::get('study_material/{studyMaterial}/edit', 'Secure\StudyMaterialController@edit');
        Route::get('study_material/{studyMaterial}/delete', 'Secure\StudyMaterialController@delete');
        Route::resource('study_material', 'Secure\StudyMaterialController');
    });

	Route::group(['middleware' => 'has_any_role:teacher,admin,admin_super_admin'], function () {
		Route::get( 'report/index', 'Secure\ReportController@index' );
	});

    //route for teacher users
    Route::group(array('middleware' => 'teacher'), function () {
        Route::get('teachergroup/data', 'Secure\TeacherGroupController@data');
        Route::get('teachergroup/timetable', 'Secure\TeacherGroupController@timetable');
        Route::get('teachergroup/print_timetable', 'Secure\TeacherGroupController@print_timetable');
        Route::get('teachergroup/{studentGroup}/show', 'Secure\TeacherGroupController@show');
        Route::get('teachergroup/{studentGroup}/students', 'Secure\TeacherGroupController@students');
        Route::get('teachergroup/{studentGroup}/generate_csv', 'Secure\TeacherGroupController@generateCsvStudentsGroup');
        Route::put('teachergroup/{studentGroup}/addstudents', 'Secure\TeacherGroupController@addstudents');
        Route::get('teachergroup/{studentGroup}/subjects', 'Secure\TeacherGroupController@subjects');
        Route::put('teachergroup/{studentGroup}/addeditsubject', 'Secure\TeacherGroupController@addeditsubject');
        Route::get('teachergroup/{studentGroup}/grouptimetable', 'Secure\TeacherGroupController@grouptimetable');
        Route::post('teachergroup/addtimetable', 'Secure\TeacherGroupController@addtimetable');
        Route::delete('teachergroup/deletetimetable', 'Secure\TeacherGroupController@deletetimetable');
        Route::resource('teachergroup', 'Secure\TeacherGroupController');

        Route::get('diary/{diary}/edit', 'Secure\DairyController@edit');
        Route::get('diary/{diary}/delete', 'Secure\DairyController@delete');

        Route::get('exam/data', 'Secure\ExamController@data');
        Route::get('exam/{exam}/show', 'Secure\ExamController@show');
        Route::get('exam/{exam}/edit', 'Secure\ExamController@edit');
        Route::get('exam/{exam}/delete', 'Secure\ExamController@delete');
        Route::resource('exam', 'Secure\ExamController');

        Route::get('teacherstudent/data', 'Secure\TeacherStudentController@data');
        Route::get('teacherstudent/{student}/behavior', 'Secure\TeacherStudentController@behavior');
        Route::post('teacherstudent/{student}/changebehavior', 'Secure\TeacherStudentController@change_behavior');
        Route::get('teacherstudent/{student}/show', 'Secure\TeacherStudentController@show');
        Route::resource('teacherstudent', 'Secure\TeacherStudentController');

        Route::post('mark/exams', 'Secure\MarkController@examsForSubject');
        Route::post('mark/marks', 'Secure\MarkController@marksForSubjectAndDate');
        Route::post('mark/mark_values', 'Secure\MarkController@markValuesForSubject');
        Route::post('mark/delete', 'Secure\MarkController@deleteMark');
        Route::post('mark/add', 'Secure\MarkController@addmark');
        Route::post('mark/{studentGroup}', 'Secure\MarkController@students');
        Route::resource('mark', 'Secure\MarkController');

        Route::post('attendance/attendance', 'Secure\AttendanceController@attendanceForDate');
        Route::post('attendance/hoursfordate', 'Secure\AttendanceController@hoursForDate');
        Route::post('attendance/delete', 'Secure\AttendanceController@deleteattendance');
        Route::post('attendance/add', 'Secure\AttendanceController@addAttendance');
        Route::post('attendance/{studentGroup}', 'Secure\AttendanceController@students');
        Route::resource('attendance', 'Secure\AttendanceController');

        Route::get('exam_attendance/{exam}/data', 'Secure\ExamAttendanceController@data');
        Route::post('exam_attendance/{exam}/attendance', 'Secure\ExamAttendanceController@getAttendance');
        Route::post('exam_attendance/{exam}/delete', 'Secure\ExamAttendanceController@deleteAttendance');
        Route::post('exam_attendance/{exam}/add', 'Secure\ExamAttendanceController@addAttendance');
        Route::get('exam_attendance/{exam}', 'Secure\ExamAttendanceController@index');

        Route::group(['prefix' => 'online_exam'], function () {
            Route::get('data', 'Secure\OnlineExamController@data');
            Route::get('download-template', 'Secure\OnlineExamController@downloadExcelTemplate');
            Route::delete('{onlineExam}', 'Secure\OnlineExamController@destroy');
            Route::put('{onlineExam}', 'Secure\OnlineExamController@update');
            Route::get('{onlineExam}/edit', 'Secure\OnlineExamController@edit');
            Route::get('{onlineExam}/delete', 'Secure\OnlineExamController@delete');
            Route::get('{onlineExam}/show', 'Secure\OnlineExamController@show');
            Route::get('{onlineExam}/show_results', 'Secure\OnlineExamController@showResults');
            Route::get('{onlineExam}/export_questions', 'Secure\OnlineExamController@exportQuestions');
            Route::get('{onlineExam}/{user}/details', 'Secure\OnlineExamController@showResultDetails');
        });
        Route::resource('online_exam', 'Secure\OnlineExamController');

	    Route::group(['prefix' => 'attendances_for_section'], function () {
		    Route::post('hoursfordate', 'Secure\AttendancesForSectionController@hoursForDate');
		    Route::post('add', 'Secure\AttendancesForSectionController@addAttendance');
		    Route::post('attendance', 'Secure\AttendancesForSectionController@attendanceForDate');
		    Route::get('students/{section}', 'Secure\AttendancesForSectionController@students');
	    });
	    Route::resource('attendances_for_section', 'Secure\AttendancesForSectionController');
    });

	Route::group(array('middleware' => 'has_any_role:teacher,human_resources,librarian,accountant,kitchen_admin,kitchen_staff,doorman'),
        function () {
		Route::group( [ 'prefix' => 'staff_leave' ], function () {
			Route::get( 'data', 'Secure\StaffLeaveController@data' );
			Route::get('{staffLeave}/edit', 'Secure\StaffLeaveController@edit');
			Route::get('{staffLeave}/delete', 'Secure\StaffLeaveController@delete');
			Route::get('{staffLeave}/show', 'Secure\StaffLeaveController@show');
			Route::delete('{staffLeave}', 'Secure\StaffLeaveController@destroy');
			Route::put('{staffLeave}', 'Secure\StaffLeaveController@update');
		} );
		Route::resource( 'staff_leave', 'Secure\StaffLeaveController' );
	});

    //route for student and parent users
    Route::group(['middleware' => 'has_any_role:student,parent'], function () {

        Route::get('studentsection/timetable', 'Secure\StudentSectionController@timetable');
        Route::get('studentsection/print_timetable', 'Secure\StudentSectionController@print_timetable');
        Route::get('studentsection/payment', 'Secure\StudentSectionController@payment');
        Route::get('studentsection/data', 'Secure\StudentSectionController@data');
        Route::get('studentsection/subjects', 'Secure\StudentSectionController@subjects');

        Route::get('report/{user}/marks', 'Secure\ReportController@marks');
        Route::get('report/{user}/attendances', 'Secure\ReportController@attendances');
        Route::get('report/{user}/notice', 'Secure\ReportController@notice');
        Route::post('report/{user}/studentsubjects', 'Secure\ReportController@getStudentSubjects');
        Route::post('report/{user}/semesters', 'Secure\ReportController@semesters');
        Route::get('report/{user}/marksforsubject', 'Secure\ReportController@marksForSubject');
        Route::get('report/{user}/attendancesforsubject', 'Secure\ReportController@attendancesForSubject');
        Route::get('report/{user}/noticeforsubject', 'Secure\ReportController@noticesForSubject');
        Route::get('report/{user}/exams', 'Secure\ReportController@exams');
        Route::get('report/{user}/examforsubject', 'Secure\ReportController@examForSubject');
        Route::get('report/{user}/online_exams', 'Secure\ReportController@onlineExams');

        Route::get('payment/{invoice}/pay', 'Secure\PaymentController@pay');
        Route::post('payment/{invoice}/paypal', 'Secure\PaymentController@paypalPayment');
        Route::post('payment/{invoice}/stripe', 'Secure\PaymentController@stripe');
        Route::get('payment/{invoice}/paypal_success', 'Secure\PaymentController@paypalSuccess');
        Route::get('payment/{invoice}/paypal_cancel', function () {
            return Redirect::to('/');
        });

        Route::get('studentsection/invoice', 'Secure\StudentSectionController@invoice');
        Route::get('studentsection/invoice/{invoice}/show', 'Secure\StudentSectionController@showInvoice');

    });

    //route for student user
    Route::group(array('middleware' => 'student'), function () {
        Route::get('online_exam/{onlineExam}/start', 'Secure\OnlineExamController@startExam');
        Route::post('online_exam/{onlineExam}/submit_access_code', 'Secure\OnlineExamController@submitAccessCode');
        Route::post('online_exam/{onlineExam}/submit_answers', 'Secure\OnlineExamController@submitAnswers');
    });

    //route for parent users
    Route::group(array('middleware' => 'parent'), function () {
        Route::get('parentsection', 'Secure\ParentSectionController@index');
        Route::get('parentsection/data', 'Secure\ParentSectionController@data');
    });

    //route for librarians
    Route::group(array('middleware' => 'librarian'), function () {
	    Route::group(['prefix' => 'book'], function () {
		    Route::get( 'data', 'Secure\BookController@data' );
		    Route::get( 'import', 'Secure\BookController@getImport' );
		    Route::post( 'import', 'Secure\BookController@postImport' );
		    Route::post( 'finish_import', 'Secure\BookController@finishImport' );
		    Route::get( 'download-template', 'Secure\BookController@downloadExcelTemplate' );
		    Route::get( '{book}/show', 'Secure\BookController@show' );
		    Route::get( '{book}/edit', 'Secure\BookController@edit' );
		    Route::get( '{book}/delete', 'Secure\BookController@delete' );
	    });
        Route::resource('book', 'Secure\BookController');

        Route::get('reservedbook/data', 'Secure\ReservedBookController@data');
        Route::put('reservedbook/{bookUser}', 'Secure\ReservedBookController@update');
        Route::delete('reservedbook/{bookUser}', 'Secure\ReservedBookController@destroy');
        Route::get('reservedbook/{bookUser}/show', 'Secure\ReservedBookController@show');
        Route::get('reservedbook/{bookUser}/delete', 'Secure\ReservedBookController@delete');
        Route::get('reservedbook/{bookUser}/issue', 'Secure\ReservedBookController@issue');
        Route::resource('reservedbook', 'Secure\ReservedBookController');

        Route::get('booklibrarian/issuebook/{user}/{book}/{id}', 'Secure\BookLibrarianController@issueBook');
        Route::post('booklibrarian/getusers', 'Secure\BookLibrarianController@getUsers');
        Route::get('booklibrarian/issuereturn/{user}', 'Secure\BookLibrarianController@issueReturnBook');
        Route::get('booklibrarian/return/{getBook}/{id}', 'Secure\BookLibrarianController@returnBook');
        Route::post('booklibrarian/getbooks', 'Secure\BookLibrarianController@getBooks');
        Route::get('booklibrarian/book/{book}', 'Secure\BookLibrarianController@getBook');
        Route::get('booklibrarian/issue_reserved_book/{bookUser}/{id}', 'Secure\BookLibrarianController@issueReservedBook');
        Route::get('booklibrarian', 'Secure\BookLibrarianController@index');

    });
    Route::group(array('middleware' => 'accountant'), function () {
        Route::group(['prefix' => 'expense'], function () {
            Route::get('data', 'Secure\ExpenseController@data');
            Route::put('{expense}', 'Secure\ExpenseController@update');
            Route::delete('{expense}', 'Secure\ExpenseController@destroy');
            Route::get('{expense}/edit', 'Secure\ExpenseController@edit');
            Route::get('{expense}/delete', 'Secure\ExpenseController@delete');
            Route::get('{expense}/show', 'Secure\ExpenseController@show');});
        Route::resource('expense', 'Secure\ExpenseController');

        Route::group(['prefix' => 'expense_category'], function () {
            Route::get('data', 'Secure\ExpenseCategoryController@data');
            Route::put('{expenseCategory}', 'Secure\ExpenseCategoryController@update');
            Route::delete('{expenseCategory}', 'Secure\ExpenseCategoryController@destroy');
            Route::get('{expenseCategory}/edit', 'Secure\ExpenseCategoryController@edit');
            Route::get('{expenseCategory}/delete', 'Secure\ExpenseCategoryController@delete');
            Route::get('{expenseCategory}/show', 'Secure\ExpenseCategoryController@show');});
        Route::resource('expense_category', 'Secure\ExpenseCategoryController');
    });

});

Route::group(array('middleware' => ['sentinel']), function () {
    Route::group(['middleware' => 'has_any_role:admin,super_admin,admin_super_admin'], function () {

        Route::group(['prefix' => 'pages'], function () {
            Route::get('data', 'Secure\PageController@data');
            Route::get('reorderpage', 'Secure\PageController@reorderpage');
            Route::get('{page}/delete', 'Secure\PageController@delete');
            Route::get('{page}/show', 'Secure\PageController@show');
            Route::get('{page}/edit', 'Secure\PageController@edit');
            Route::put('{page}', 'Secure\PageController@update');
        });
        Route::resource('pages', 'Secure\PageController');
    });
});

/**
 * Installation
 */
Route::group(['prefix' => 'install'], function () {
    Route::get('', 'InstallController@index');
    Route::get('requirements', 'InstallController@requirements');
    Route::get('permissions', 'InstallController@permissions');
    Route::get('verify', 'InstallController@verify');
    Route::post('verify', 'InstallController@verifyApplication');
    Route::get('database', 'InstallController@database');
    Route::get('start-installation', 'InstallController@installation');
    Route::post('start-installation', 'InstallController@installation');
    Route::get('install', 'InstallController@install');
    Route::post('install', 'InstallController@install');
    Route::get('settings', 'InstallController@settings');
    Route::post('settings', 'InstallController@settingsSave');
    Route::get('email_settings', 'InstallController@settingsEmail');
    Route::post('email_settings', 'InstallController@settingsEmailSave');
    Route::get('complete', 'InstallController@complete');
    Route::get('error', 'InstallController@error');
});

/**
 * Update
 */
Route::group(['prefix' => 'update/{version}'], function () {
    Route::get('', 'UpdateController@index');
    Route::post('start-update', 'UpdateController@update');
    Route::get('complete', 'UpdateController@complete');
    Route::get('error', 'UpdateController@error');
});