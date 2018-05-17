<div class="profile">
    <br/>
    @if(session('was_super_admin'))
        <a href="{{url('back_to_super_admin')}}">{{trans('left_menu.back_to_super_admin')}}</a>
    @endif
</div>
<br/>

<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3>{{ trans('left_menu.admin') }}</h3>
        <ul class="nav side-menu metismenu" id="menu">
            <li {!! (Request::is('/') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/')}}">
                    <i class="menu-icon fa fa-fw fa-dashboard text-default"></i>
                    <span class="mm-text ">{{ trans('secure.dashboard') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'schools') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/schools')}}">
                    <i class="menu-icon fa fa-server text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.schools') }}</span>
                </a>
            </li>
            @if($user->authorized('notice.show'))
            <li {!! ((starts_with(Route::current()->uri, 'notice') && !starts_with(Route::current()->uri, 'noticetype'))? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/notice')}}">
                    <i class="menu-icon fa fa-paper-plane text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.notice') }}</span>
                </a>
            </li>
            @endif
            @if($user->authorized('account_type.show'))
            <li {!! (starts_with(Route::current()->uri, 'account_type') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/account_type')}}">
                    <i class="menu-icon fa fa-check-square text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.account_type') }}</span>
                </a>
            </li>
            @endif
            @if($user->authorized('account.show'))
            <li {!! ((starts_with(Route::current()->uri, 'account') &&
                        !starts_with(Route::current()->uri,'account_type'))
                    ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/account')}}">
                    <i class="menu-icon fa fa-check-circle-o text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.account') }}</span>
                </a>
            </li>
            @endif
            @if($user->authorized('voucher.show'))
            <li {!! (starts_with(Route::current()->uri, 'voucher') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/voucher')}}">
                    <i class="menu-icon fa fa-credit-card text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.voucher') }}</span>
                </a>
            </li>
            @endif
            @if($user->authorized('school_exam.show'))
            <li {!! ((starts_with(Route::current()->uri, 'admin_exam'))? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/admin_exam')}}">
                    <i class="menu-icon fa fa-map-marker text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.admin_exams') }}</span>
                </a>
            </li>
            @endif
            @if($user->authorized('diary.show'))
            <li {!! (starts_with(Route::current()->uri, 'diary') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/diary')}}">
                    <i class="menu-icon fa fa-comment text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.diary') }}</span>
                </a>
            </li>
            @endif
            @if($user->authorized('section.show'))
            <li {!! (starts_with(Route::current()->uri, 'section') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/section')}}">
                    <i class="menu-icon fa fa-graduation-cap text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.sections') }}</span>
                </a>
            </li>
            @endif
            @if($user->authorized('level.show'))
            <li {!! (starts_with(Route::current()->uri, 'levels') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/levels')}}">
                    <i class="menu-icon fa fa-level-up text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.levels') }}</span>
                </a>
            </li>
            @endif
            @if($user->authorized('student.show'))
            <li {!! (ends_with(Route::current()->uri, 'student') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/student')}}">
                    <i class="menu-icon fa fa-users text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.students') }}</span>
                </a>
            </li>
            @endif
            @if($user->authorized('registration.show'))
                <li {!! (ends_with(Route::current()->uri, 'registration') ? 'class="active" id="active"' : '') !!}>
                    <a href="{{url('/registration')}}">
                        <i class="menu-icon fa fa-users text-default"></i>
                        <span class="mm-text">{{ trans('left_menu.registrations') }}</span>
                    </a>
                </li>
            @endif
            @if($user->authorized('student_final_mark.show'))
            <li {!! (starts_with(Route::current()->uri, 'student_final_mark') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/student_final_mark')}}">
                    <i class="menu-icon fa fa-list-ol text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.student_final_mark') }}</span>
                </a>
            </li>
            @endif
            @if($user->authorized('student_attendances_admin.show'))
            <li {!! (starts_with(Route::current()->uri, 'student_attendances_admin') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/student_attendances_admin')}}">
                    <i class="menu-icon fa fa-list-alt text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.student_attendances_admin') }}</span>
                </a>
            </li>
            <li {!! (ends_with(Route::current()->uri, 'attendances_by_subject') ? 'class="active"' : '') !!}>
                <a href="{{url('/attendances_by_subject')}}">
                    <i class="menu-icon fa fa-info text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.attendances_by_subject') }}</span>
                </a>
            </li>
            @endif
            @if($user->authorized('parent.show'))
            <li {!! (starts_with(Route::current()->uri, 'parent') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/parent')}}">
                    <i class="menu-icon fa fa-user-md text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.parents') }}</span>
                </a>
            </li>
            @endif
            @if($user->authorized('human_resource.show'))
            <li {!! (starts_with(Route::current()->uri, 'human_resource') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/human_resource')}}">
                    <i class="menu-icon fa fa-user-md text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.human_resource') }}</span>
                </a>
            </li>
            @endif
            @if($user->authorized('teacher.show'))
            <li {!! (starts_with(Route::current()->uri, 'teacher') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/teacher')}}">
                    <i class="menu-icon fa fa-user-secret text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.teachers') }}</span>
                </a>
            </li>
            @endif
            @if($user->authorized('librarian.show'))
            <li {!! (starts_with(Route::current()->uri, 'librarian') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/librarian')}}">
                    <i class="menu-icon fa fa-user text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.librarians') }}</span>
                </a>
            </li>
            @endif
            @if($user->authorized('accountant.show'))
            <li {!! (starts_with(Route::current()->uri, 'accountant') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/accountant')}}">
                    <i class="menu-icon fa fa-tty text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.accountants') }}</span>
                </a>
            </li>
            @endif
            @if($user->authorized('applicant.show'))
                <li {!! (starts_with(Route::current()->uri, 'applicant') ? 'class="active" id="active"' : '') !!}>
                    <a href="{{url('/applicant')}}">
                        <i class="menu-icon fa fa-info-circle text-default"></i>
                        <span class="mm-text">{{ trans('left_menu.applicants') }}</span>
                    </a>
                </li>
            @endif
            @if($user->authorized('visitor.show'))
            <li {!! (starts_with(Route::current()->uri, 'visitor') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/visitor')}}">
                    <i class="menu-icon fa fa-user text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.visitors') }}</span>
                </a>
            </li>
            @endif
            @if($user->authorized('scholarship.show'))
            <li {!! (starts_with(Route::current()->uri, 'scholarship') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/scholarship')}}">
                    <i class="menu-icon fa fa-gift text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.scholarship') }}</span>
                </a>
            </li>
            @endif
            @if($user->authorized('salary.show'))
            <li {!! (starts_with(Route::current()->uri, 'salary') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/salary')}}">
                    <i class="menu-icon fa fa-credit-card text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.salary') }}</span>
                </a>
            </li>
            @endif
            @if($user->authorized('fee_category.show'))
            <li {!! (starts_with(Route::current()->uri, 'fee_category') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/fee_category')}}">
                    <i class="menu-icon fa fa-list text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.fee_categories') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'task') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/task')}}">
                    <i class="menu-icon fa fa-thumb-tack text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.task') }}</span>
                </a>
            </li>
            @endif
            <li {!! (starts_with(Route::current()->uri, 'report/index') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/report/index')}}">
                    <i class="menu-icon fa fa-flag-checkered text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.reports') }}</span>
                </a>
            </li>
            @if($user->authorized('sms_message.show'))
                @if(Settings::get('sms_driver')!=""  && Settings::get('sms_driver') !='none')
                    <li {!! (starts_with(Route::current()->uri, 'sms_message') ? 'class="active" id="active"' : '') !!}>
                        <a href="{{url('/sms_message')}}">
                            <i class="menu-icon fa fa-envelope text-default"></i>
                            <span class="mm-text">{{ trans('left_menu.sms_message') }}</span>
                        </a>
                    </li>
                @endif
            @endif
            @if($user->authorized('dormitory.show') ||
            $user->authorized('dormitoryroom.show') ||
            $user->authorized('dormitorybed.show'))
            <li class="{!! (starts_with(Route::current()->uri, 'dormitory') ? 'active' : '') !!}">
                <a>
                    <i class="menu-icon fa fa-bed text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.dormitories') }}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="nav child_menu">
                    @if($user->authorized('dormitory.show'))
                        <li {!! (ends_with(Route::current()->uri, 'dormitory')  ? 'class="active"' : '') !!}>
                            <a href="{{url('/dormitory')}}">
                                <i class="menu-icon fa fa-list text-default"></i>
                                <span class="mm-text">{{ trans('left_menu.dormitories') }}</span>
                            </a>
                        </li>
                    @endif
                    @if($user->authorized('dormitoryroom.show'))
                        <li {!! (starts_with(Route::current()->uri, 'dormitoryroom') ? 'class="active" id="active"' : '') !!}>
                            <a href="{{url('/dormitoryroom')}}">
                                <i class="menu-icon fa fa-list-ol text-default"></i>
                                <span class="mm-text">{{ trans('left_menu.dormitory_rooms') }}</span>
                            </a>
                        </li>
                    @endif
                    @if( $user->authorized('dormitorybed.show'))
                        <li {!! (starts_with(Route::current()->uri, 'dormitorybed')  ? 'class="active" id="active"' : '') !!}>
                            <a href="{{url('/dormitorybed')}}">
                                <i class="menu-icon fa  fa-bed text-default"></i>
                                <span class="mm-text">{{ trans('left_menu.dormitory_beds') }}</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
            @endif
            @if($user->authorized('transportation.show'))
                <li {!! (ends_with(Route::current()->uri, 'transportation') ? 'class="active"' : '') !!}>
                    <a href="{{url('/transportation')}}">
                        <i class="menu-icon fa fa-compass text-default"></i>
                        <span class="mm-text">{{ trans('left_menu.transportation') }}</span>
                    </a>
                </li>
            @endif
            @if($user->authorized('invoice.show') ||
                $user->authorized('debtor.show') ||
                $user->authorized('payments.show'))
            <li class="{!! (starts_with(Route::current()->uri, 'invoice')
                        || starts_with(Route::current()->uri, 'debtor')
                        || starts_with(Route::current()->uri, 'payment') ? 'active' : '') !!}">
                <a>
                    <i class="menu-icon fa fa-list text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.payment') }}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="nav child_menu">
                    @if($user->authorized('invoice.show'))
                        <li {!! (starts_with(Route::current()->uri, 'invoice') ? 'class="active" id="active"' : '') !!}>
                            <a href="{{url('/invoice')}}">
                                <i class="menu-icon fa fa-credit-card text-default"></i>
                                <span class="mm-text">{{ trans('left_menu.invoice') }}</span>
                            </a>
                        </li>
                    @endif
                    @if($user->authorized('debtor.show'))
                        <li {!! (starts_with(Route::current()->uri, 'debtor') ? 'class="active" id="active"' : '') !!}>
                            <a href="{{url('/debtor')}}">
                                <i class="menu-icon fa fa-money text-default"></i>
                                <span class="mm-text">{{ trans('left_menu.debtor') }}</span>
                            </a>
                        </li>
                    @endif
                    @if($user->authorized('payment.show'))
                        <li {!! (starts_with(Route::current()->uri, 'payment') ? 'class="active" id="active"' : '') !!}>
                            <a href="{{url('/payment')}}">
                                <i class="menu-icon fa fa-money text-default"></i>
                                <span class="mm-text">{{ trans('left_menu.payment') }}</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
            @endif
            @if($user->authorized('holiday.show'))
                <li {!! (starts_with(Route::current()->uri, 'holiday') ? 'class="active" id="active"' : '') !!}>
                    <a href="{{url('/holiday')}}">
                        <i class="menu-icon fa fa-calendar-o text-default"></i>
                        <span class="mm-text">{{ trans('left_menu.holiday') }}</span>
                    </a>
                </li>
            @endif
            @if($user->authorized('supplier.show'))
                <li {!! (ends_with(Route::current()->uri, 'supplier') ? 'class="active"' : '') !!}>
                    <a href="{{url('/supplier')}}">
                        <i class="menu-icon fa fa-balance-scale text-default"></i>
                        <span class="mm-text">{{ trans('left_menu.suppliers') }}</span>
                    </a>
                </li>
            @endif
            @if($user->authorized('kitchen_admin.show'))
                <li {!! (ends_with(Route::current()->uri, 'kitchen_admin') ? 'class="active"' : '') !!}>
                    <a href="{{url('/kitchen_admin')}}">
                        <i class="menu-icon fa fa-comments-o text-default"></i>
                        <span class="mm-text">{{ trans('left_menu.kitchen_admins') }}</span>
                    </a>
                </li>
            @endif
            @if($user->authorized('kitchen_staff.show'))
                <li {!! (ends_with(Route::current()->uri, 'kitchen_staff') ? 'class="active"' : '') !!}>
                    <a href="{{url('/kitchen_staff')}}">
                        <i class="menu-icon fa fa-commenting text-default"></i>
                        <span class="mm-text">{{ trans('left_menu.kitchen_staffs') }}</span>
                    </a>
                </li>
            @endif
            @if($user->authorized('meal_type.show'))
            <li {!! (ends_with(Route::current()->uri, 'meal_type') ? 'class="active"' : '') !!}>
                <a href="{{url('/meal_type')}}">
                    <i class="menu-icon fa fa-lemon-o text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.meal_type') }}</span>
                </a>
            </li>
            @endif
            @if($user->authorized('meal.show'))
            <li {!! (ends_with(Route::current()->uri, 'meal') ? 'class="active"' : '') !!}>
                <a href="{{url('/meal')}}">
                    <i class="menu-icon fa fa-apple text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.meal') }}</span>
                </a>
            </li>
            @endif
            @if($user->authorized('entry_mode.show'))
                <li {!! (starts_with(Route::current()->uri, 'entry_mode') ? 'class="active" id="active"' : '') !!}>
                    <a href="{{url('/entry_mode')}}">
                        <i class="menu-icon fa fa-address-card text-default"></i>
                        <span class="mm-text">{{ trans('left_menu.entry_mode') }}</span>
                    </a>
                </li>
            @endif
            @if($user->authorized('session.show'))
                <li {!! (starts_with(Route::current()->uri, 'session') ? 'class="active" id="active"' : '') !!}>
                    <a href="{{url('/session')}}">
                        <i class="menu-icon fa fa-sellsy text-default"></i>
                        <span class="mm-text">{{ trans('left_menu.session') }}</span>
                    </a>
                </li>
            @endif
            @if($user->authorized('intake_period.show'))
                <li {!! (starts_with(Route::current()->uri, 'intake_period') ? 'class="active" id="active"' : '') !!}>
                    <a href="{{url('/intake_period')}}">
                        <i class="menu-icon fa fa-hand-peace-o text-default"></i>
                        <span class="mm-text">{{ trans('left_menu.intake_period') }}</span>
                    </a>
                </li>
            @endif
            @if($user->authorized('fee_period.show'))
                <li {!! (starts_with(Route::current()->uri, 'fee_period') ? 'class="active" id="active"' : '') !!}>
                    <a href="{{url('/fee_period')}}">
                        <i class="menu-icon fa fa-credit-card text-default"></i>
                        <span class="mm-text">{{ trans('left_menu.fee_period') }}</span>
                    </a>
                </li>
            @endif
            <li {!! (ends_with(Route::current()->uri, 'meal_table') ? 'class="active"' : '') !!}>
                <a href="{{url('/meal_table')}}">
                    <i class="menu-icon fa fa-cutlery text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.meal_table') }}</span>
                </a>
            </li>
            @if($user->authorized('teacher_duty.show'))
                <li {!! (ends_with(Route::current()->uri, 'teacher_duty') ? 'class="active"' : '') !!}>
                    <a href="{{url('/teacher_duty')}}">
                        <i class="menu-icon fa fa-angle-double-up text-default"></i>
                        <span class="mm-text">{{ trans('left_menu.teacher_duty') }}</span>
                    </a>
                </li>
            @endif
            @if($user->authorized('all_mails.show'))
                <li {!! (starts_with(Route::current()->uri, 'all_mails') ? 'class="active" id="active"' : '') !!}>
                    <a href="{{url('/all_mails')}}">
                        <i class="menu-icon fa fa-envelope text-default"></i>
                        <span class="mm-text">{{ trans('left_menu.all_schools_mails') }}</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</div>