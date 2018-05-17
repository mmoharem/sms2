<div class="profile">
    <br/>
</div><br/>

<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3>{{ trans('left_menu.super_admin') }}</h3>
        <ul class="nav side-menu metismenu" id="menu">
            <li {!! (Request::is('/') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/')}}">
                    <i class="menu-icon fa fa-fw fa-dashboard text-default"></i>
                    <span class="mm-text ">{{ trans('secure.dashboard') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'schoolyear') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/schoolyear')}}">
                    <i class="menu-icon fa fa-briefcase text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.school_years') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'semester') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/semester')}}">
                    <i class="menu-icon fa fa-list text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.semesters') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'department') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/department')}}">
                    <i class="menu-icon fa fa-arrows-v text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.departments') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'direction') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/direction')}}">
                    <i class="menu-icon fa fa-arrows-alt text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.directions') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'school_direction') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/school_direction')}}">
                    <i class="menu-icon fa fa-arrows-h text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.school_direction') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'marksystem') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/marksystem')}}">
                    <i class="menu-icon fa fa-adjust text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.mark_system') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'subject') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/subject')}}">
                    <i class="menu-icon fa fa-list text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.subjects') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'marktype') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/marktype')}}">
                    <i class="menu-icon fa fa-list-ul text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.mark_type') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'markvalue') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/markvalue')}}">
                    <i class="menu-icon fa fa-list-ol text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.mark_value') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'noticetype') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/noticetype')}}">
                    <i class="menu-icon fa fa-list-alt text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.notice_type') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'behavior') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/behavior')}}">
                    <i class="menu-icon fa fa-indent text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.behavior') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'timetable_period') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/timetable_period')}}">
                    <i class="menu-icon fa fa-table text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.timetable_period') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'staff_leave_type') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/staff_leave_type')}}">
                    <i class="menu-icon fa fa-lemon-o text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.staff_leave_type') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'schools') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/schools')}}">
                    <i class="menu-icon fa fa-server text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.schools') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'school_admin') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/school_admin')}}">
                    <i class="menu-icon fa fa-user-md text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.school_admin') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'human_resource') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/human_resource')}}">
                    <i class="menu-icon fa fa-user-md text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.human_resource') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'visitor') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/visitor')}}">
                    <i class="menu-icon fa fa-user text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.visitors') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'librarian') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/librarian')}}">
                    <i class="menu-icon fa fa-user text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.librarians') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'accountant') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/accountant')}}">
                    <i class="menu-icon fa fa-tty text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.accountants') }}</span>
                </a>
            </li>
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
            <li {!! (ends_with(Route::current()->uri, 'slider') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/slider')}}">
                    <i class="menu-icon fa fa-sliders text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.slider') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'login_history') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/login_history')}}">
                    <i class="menu-icon fa fa-sign-in text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.login_history') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'pages') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/pages')}}">
                    <i class="menu-icon fa fa-pagelines text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.page') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'certificate') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/certificate')}}">
                    <i class="menu-icon fa fa-certificate text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.certificate') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'blog_category') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/blog_category')}}">
                    <i class="menu-icon fa fa-barcode text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.blog_categories') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'blog') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/blog')}}">
                    <i class="menu-icon fa fa-bars text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.blog') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'custom_user_field') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/custom_user_field')}}">
                    <i class="menu-icon fa fa-th-list text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.custom_user_field') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'faq_category') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/faq_category')}}">
                    <i class="menu-icon fa fa-question-circle text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.faq_category') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'faq') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/faq')}}">
                    <i class="menu-icon fa fa-question text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.faq') }}</span>
                </a>
            </li>
            <li {!! (ends_with(Route::current()->uri, 'supplier') ? 'class="active"' : '') !!}>
                <a href="{{url('/supplier')}}">
                    <i class="menu-icon fa fa-balance-scale text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.suppliers') }}</span>
                </a>
            </li>
            <li {!! (ends_with(Route::current()->uri, 'kitchen_admin') ? 'class="active"' : '') !!}>
                <a href="{{url('/kitchen_admin')}}">
                    <i class="menu-icon fa fa-comments-o text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.kitchen_admins') }}</span>
                </a>
            </li>
            <li {!! (ends_with(Route::current()->uri, 'kitchen_staff') ? 'class="active"' : '') !!}>
                <a href="{{url('/kitchen_staff')}}">
                    <i class="menu-icon fa fa-commenting text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.kitchen_staffs') }}</span>
                </a>
            </li>
            <li {!! (ends_with(Route::current()->uri, 'doorman') ? 'class="active"' : '') !!}>
                <a href="{{url('/doorman')}}">
                    <i class="menu-icon fa fa-arrows text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.doormans') }}</span>
                </a>
            </li>
            <li {!! (ends_with(Route::current()->uri, 'teacher_duty') ? 'class="active"' : '') !!}>
                <a href="{{url('/teacher_duty')}}">
                    <i class="menu-icon fa fa-angle-double-up text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.teacher_duty') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'all_mails') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/all_mails')}}">
                    <i class="menu-icon fa fa-envelope text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.all_mails') }}</span>
                </a>
            </li>
            <li {!! (ends_with(Route::current()->uri, 'block_login') ? 'class="active"' : '') !!}>
                <a href="{{url('/block_login')}}">
                    <i class="menu-icon fa fa-lock text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.block_login') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'qualification') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/qualification')}}">
                    <i class="menu-icon fa fa-fighter-jet text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.qualification') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'religion') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/religion')}}">
                    <i class="menu-icon fa fa-reorder text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.religion') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'denomination') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/denomination')}}">
                    <i class="menu-icon fa fa-check-circle-o text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.denomination') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'marital_status') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/marital_status')}}">
                    <i class="menu-icon fa fa-mars-double text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.marital_status') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'option') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/option')}}">
                    <i class="menu-icon fa fa-cog text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.option') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'country') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/country')}}">
                    <i class="menu-icon fa fa-globe text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.country') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'setting') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/setting')}}">
                    <i class="menu-icon fa fa-cogs text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.settings') }}</span>
                </a>
            </li>
        </ul>
    </div>
</div>