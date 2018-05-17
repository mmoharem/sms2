<?php

use Illuminate\Database\Seeder;
use App\Models\Option;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        //truncate existing data
        DB::table('options')->truncate();

        //payment_methods options
        Option::create([
            'category' => 'payment_methods',
            'school_id' => 0,
            'title' => 'Cash',
            'value' => 'Cash'
        ]);
        Option::create([
            'category' => 'payment_methods',
            'title' => 'Check',
            'school_id' => 0,
            'value' => 'Check'
        ]);
        Option::create([
            'category' => 'payment_methods',
            'title' => 'Bank Account',
            'school_id' => 0,
            'value' => 'Bank Account'
        ]);
        Option::create([
            'category' => 'payment_methods',
            'title' => 'Credit Card',
            'school_id' => 0,
            'value' => 'Credit Card'
        ]);

        //status_payment options
        Option::create([
            'category' => 'status_payment',
            'title' => 'Payed',
            'school_id' => 0,
            'value' => 'Payed'
        ]);
        Option::create([
            'category' => 'status_payment',
            'title' => 'Suspended',
            'school_id' => 0,
            'value' => 'Suspended'
        ]);
        Option::create([
            'category' => 'status_payment',
            'title' => 'Canceled',
            'school_id' => 0,
            'value' => 'Canceled'
        ]);
        Option::create([
            'category' => 'status_payment',
            'title' => 'Pending',
            'school_id' => 0,
            'value' => 'Pending'
        ]);
        Option::create([
            'category' => 'status_payment',
            'title' => 'Success With Warning',
            'school_id' => 0,
            'value' => 'Success With Warning'
        ]);

        //currency statuses
        Option::create([
            'category' => 'currency',
            'school_id' => 0,
            'title' => 'USD',
            'value' => 'USD'
        ]);
        Option::create([
            'category' => 'currency',
            'school_id' => 0,
            'title' => 'EUR',
            'value' => 'EUR'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'CAD',
	        'value' => 'CAD'
        ]);
        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'GBP',
	        'value' => 'GBP'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'AUD',
	        'value' => 'AUD'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'ANG',
	        'value' => 'ANG'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'AOA',
	        'value' => 'AOA'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'ARS',
	        'value' => 'ARS'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'BBD',
	        'value' => 'BBD'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'BGL',
	        'value' => 'BGL'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'BHD',
	        'value' => 'BHD'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'BND',
	        'value' => 'BND'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'BRL',
	        'value' => 'BRL'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'CHF',
	        'value' => 'CHF'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'CLF',
	        'value' => 'CLF'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'CLP',
	        'value' => 'CLP'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'CNY',
	        'value' => 'CNY'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'COP',
	        'value' => 'COP'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'CRC',
	        'value' => 'CRC'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'CZK',
	        'value' => 'CZK'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'DKK',
	        'value' => 'DKK'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'EEK',
	        'value' => 'EEK'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'EGP',
	        'value' => 'EGP'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'FJD',
	        'value' => 'FJD'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'GTQ',
	        'value' => 'GTQ'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'HKD',
	        'value' => 'HKD'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'HRK',
	        'value' => 'HRK'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'HUF',
	        'value' => 'HUF'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'IDR',
	        'value' => 'IDR'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'ILS',
	        'value' => 'ILS'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'INR',
	        'value' => 'INR'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'JPY',
	        'value' => 'JPY'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'KES',
	        'value' => 'KES'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'KRW',
	        'value' => 'KRW'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'KWD',
	        'value' => 'KWD'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'KYD',
	        'value' => 'KYD'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'LTL',
	        'value' => 'LTL'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'LVL',
	        'value' => 'LVL'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'MVR',
	        'value' => 'MVR'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'MXN',
	        'value' => 'MXN'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'MYR',
	        'value' => 'MYR'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'NGN',
	        'value' => 'NGN'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'NOK',
	        'value' => 'NOK'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'NZD',
	        'value' => 'NZD'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'OMR',
	        'value' => 'OMR'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'PEN',
	        'value' => 'PEN'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'PHP',
	        'value' => 'PHP'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'PLN',
	        'value' => 'PLN'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'QAR',
	        'value' => 'QAR'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'RON',
	        'value' => 'RON'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'RUB',
	        'value' => 'RUB'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'SAR',
	        'value' => 'SAR'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'SEK',
	        'value' => 'SEK'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'SGD',
	        'value' => 'SGD'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'THB',
	        'value' => 'THB'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'TTD',
	        'value' => 'TTD'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'TWD',
	        'value' => 'TWD'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'UAH',
	        'value' => 'UAH'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'VEF',
	        'value' => 'VEF'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'VND',
	        'value' => 'VND'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'XCD',
	        'value' => 'XCD'
        ]);

        Option::create([
	        'category' => 'currency',
	        'school_id' => 0,
	        'title' => 'ZAR',
	        'value' => 'ZAR'
        ]);


        //Cloud Servers
        Option::create([
            'category' => 'backup_type',
            'school_id' => 0,
            'title' => 'local',
            'value' => 'Local'
        ]);

        Option::create([
            'category' => 'backup_type',
            'school_id' => 0,
            'title' => 'dropbox',
            'value' => 'Dropbox'
        ]);

        Option::create([
            'category' => 'backup_type',
            'school_id' => 0,
            'title' => 's3',
            'value' => 'Amazon S3'
        ]);

        //report_type options
        Option::create([
            'category' => 'report_type',
            'school_id' => 0,
            'title' => 'List of students attendances',
            'value' => 'list_attendances'
        ]);
        Option::create([
            'category' => 'report_type',
            'school_id' => 0,
            'title' => 'List of students marks',
            'value' => 'list_marks'
        ]);
        Option::create([
            'category' => 'report_type',
            'school_id' => 0,
            'title' => 'List of marks for selected exam',
            'value' => 'list_exam_marks'
        ]);
        Option::create([
            'category' => 'report_type',
            'school_id' => 0,
            'title' => 'List of students behaviors',
            'value' => 'list_behaviors'
        ]);

        Option::create([
            'category' => 'report_type',
            'category' => 'report_type',
            'school_id' => 0,
            'title' => 'Students cards (all marks and attendances)',
            'value' => 'student_cards'
        ]);

        Option::create([
            'category' => 'report_type',
            'school_id' => 0,
            'title' => 'List of average students marks for all subjects from the current semester',
            'value' => 'list_average_marks_all_subjects'
        ]);

        //attendance_student_type options
        Option::create([
            'category' => 'attendance_type',
            'school_id' => 0,
            'title' => 'Present',
            'value' => 'Present'
        ]);
        Option::create([
            'category' => 'attendance_type',
            'school_id' => 0,
            'title' => 'Absent',
            'value' => 'Absent'
        ]);
        Option::create([
            'category' => 'attendance_type',
            'school_id' => 0,
            'title' => 'Late',
            'value' => 'Late'
        ]);
        Option::create([
            'category' => 'attendance_type',
            'school_id' => 0,
            'title' => 'Late with excuse',
            'value' => 'Late with excuse'
        ]);

        //document type
        Option::create([
            'category' => 'student_document_type',
            'school_id' => 0,
            'title' => 'Transfer certificate',
            'value' => 'Transfer certificate'
        ]);
        Option::create([
            'category' => 'staff_document_type',
            'school_id' => 0,
            'title' => 'Resume',
            'value' => 'Resume'
        ]);

        //exam type
        Option::create([
            'category' => 'exam_type',
            'school_id' => 0,
            'title' => 'Oral exam',
            'value' => 'Oral exam'
        ]);

        //feedback_type options
        Option::create([
            'category' => 'feedback_type',
            'school_id' => 0,
            'title' => 'Praise',
            'value' => 'Praise'
        ]);
        Option::create([
            'category' => 'feedback_type',
            'school_id' => 0,
            'title' => 'Contact',
            'value' => 'Contact'
        ]);
        Option::create([
            'category' => 'feedback_type',
            'school_id' => 0,
            'title' => 'Error',
            'value' => 'Error'
        ]);
        Option::create([
            'category' => 'feedback_type',
            'school_id' => 0,
            'title' => 'Proposal',
            'value' => 'Proposal'
        ]);
        Option::create([
            'category' => 'feedback_type',
            'school_id' => 0,
            'title' => 'Request',
            'value' => 'Request'
        ]);

        //SMS Servers

        Option::create([
            'category' => 'sms_driver',
            'school_id' => 0,
            'title' => 'none',
            'value' => '...'
        ]);

        Option::create([
            'category' => 'sms_driver',
            'school_id' => 0,
            'title' => 'callfire',
            'value' => 'CallFire'
        ]);

        Option::create([
            'category' => 'sms_driver',
            'school_id' => 0,
            'title' => 'eztexting',
            'value' => 'EzTexting'
        ]);

        Option::create([
            'category' => 'sms_driver',
            'school_id' => 0,
            'title' => 'labsmobile',
            'value' => 'LabsMobile'
        ]);

        Option::create([
            'category' => 'sms_driver',
            'school_id' => 0,
            'title' => 'mozeo',
            'value' => 'Mozeo'
        ]);

        Option::create([
            'category' => 'sms_driver',
            'school_id' => 0,
            'title' => 'nexmo',
            'value' => 'Nexmo'
        ]);

        Option::create([
            'category' => 'sms_driver',
            'school_id' => 0,
            'title' => 'twilio',
            'value' => 'Twilio'
        ]);

        Option::create([
            'category' => 'sms_driver',
            'school_id' => 0,
            'title' => 'zenvia',
            'value' => 'Zenvia'
        ]);
	    Option::create([
		    'category' => 'sms_driver',
		    'school_id' => 0,
		    'title' => 'bulk_sms',
		    'value' => 'Bulk SMS'
	    ]);
	    Option::create([
		    'category' => 'sms_driver',
		    'school_id' => 0,
		    'title' => 'msg91',
		    'value' => 'MSG91'
	    ]);

        // book_category
        Option::create([
            'category' => 'book_category',
            'school_id' => 0,
            'title' => 'Books',
            'value' => 'books'
        ]);

        Option::create([
            'category' => 'book_category',
            'school_id' => 0,
            'title' => 'Journals',
            'value' => 'journals'
        ]);

        Option::create([
            'category' => 'book_category',
            'school_id' => 0,
            'title' => 'Newspapers',
            'value' => 'newspapers'
        ]);

        Option::create([
            'category' => 'book_category',
            'school_id' => 0,
            'title' => 'Magazines',
            'value' => 'magazines'
        ]);

        //borrowing_period
        Option::create([
            'category' => 'borrowing_period',
            'school_id' => 0,
            'title' => 'Internal use',
            'value' => '0'
        ]);
        Option::create([
            'category' => 'borrowing_period',
            'school_id' => 0,
            'title' => 'Overnight',
            'value' => '1'
        ]);
        Option::create([
            'category' => 'borrowing_period',
            'school_id' => 0,
            'title' => 'Short period',
            'value' => '3'
        ]);
        Option::create([
            'category' => 'borrowing_period',
            'school_id' => 0,
            'title' => 'Long period',
            'value' => '7'
        ]);

        Option::create([
            'category' => 'theme_backend',
            'school_id' => 0,
            'title' => 'Backend Theme',
            'value' => '.left_col,.nav-md ul.nav.child_menu li:before,.nav-sm ul.nav.child_menu,.nav.side-menu>li.active>a,.nav_menu,.panel_toolbox>li>a:hover,.top_nav .nav .open>a,.top_nav .nav .open>a:focus,.top_nav .nav .open>a:hover,.top_nav .nav>li>a:focus,.top_nav .nav>li>a:hover{background:#menu_bg_color#!important}.nav-sm .nav.child_menu li.active,.nav-sm .nav.side-menu li.active-sm{border-right:5px solid #menu_active_bg_color#!important}.nav-sm>.nav.side-menu>li.active-sm>a{color:#menu_active_bg_color#!important}.main_menu span.fa,.profile_info h2,.profile_info span{color:#menu_color#!important}.nav_menu{border-bottom:1px solid #menu_color#!important}.navbar-brand,.navbar-nav>li>a{color:#menu_color#!important}a{color:#ffffff!important}.nav.side-menu>li>a:hover{color:#menu_active_color#!important}.nav li li.current-page a,.nav.child_menu li li a.active,.nav.child_menu li li a:hover,.nav.child_menu>li>a,.nav.navbar-nav>li>a,.nav.side-menu>li>a,.navbar-brand,.navbar-nav>li>a{color:#menu_color#!important}.nav-md ul.nav.child_menu li:after{border-left:1px solid #menu_bg_color#!important}.nav.side-menu>li.active,.nav.side-menu>li.current-page{border-right:5px solid #menu_active_border_right_color#!important}.dropdown-menu,.paging_full_numbers a.paginate_active,.paging_full_numbers a.paginate_button{border:1px solid!important}.nav.top_menu>li>a{color:#menu_bg_color#!important}.nav.child_menu>li>a,.pagination.pagination-split li a,.panel_toolbox>li>a{color:#menu_color#!important}.paging_full_numbers a.paginate_button{background-color:#menu_color#!important}.paging_full_numbers a.paginate_button:hover{background-color:#menu_active_color#!important}.paging_full_numbers a.paginate_active{background-color:#menu_bg_color#!important}table.display tr.even.row_selected td{background-color:#menu_active_color#!important}table.display tr.odd.row_selected td{background-color:#menu_color#!important}.dropdown-menu>li>a{color:#menu_bg_color#!important}.navbar-nav .open .dropdown-menu{background:0 0!important;border:1px solid!important}.nav_title{background:0 0!important}body{background-color:transparent!important}a.tabs_settings{color:#menu_bg_color#!important}'
        ]);

        Option::create([
            'category' => 'theme_frontend',
            'school_id' => 0,
            'title' => 'Frontend Theme',
            'value' => 'a:focus,a:hover,body,h1,h2,h3,h4,h5,h6{color:#frontend_text_color#!important}.navbar,.navbar-inverse{border-color:#frontend_menu_bg_color#!important}body{background-color:#frontend_bg_color#!important}.navbar,.navbar-inverse,.navbar-inverse .navbar-nav>.active>a,vbar .navbar-nav>.active>a{background:0 0!important}a{color:#frontend_link_color#!important}.navbar .navbar-brand{color:#frontend_text_color#!important}.navbar .navbar-brand i{color:#frontend_link_color#!important}.navbar-inverse .navbar-brand{color:#frontend_text_color#!important}.navbar-inverse .navbar-brand i{color:#frontend_link_color#!important}'
        ]);

        Eloquent::reguard();
    }
}