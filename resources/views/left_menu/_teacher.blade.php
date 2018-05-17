<div class="profile">
    <br/>
    @if(session('was_admin'))
        <a href="{{url('back_to_admin')}}">{{trans('left_menu.back_to_admin')}}</a>
    @endif
    @if(session('was_admin_school_admin'))
        <a href="{{url('admin_school_admin')}}">{{trans('left_menu.back_to_admin')}}</a>
    @endif
</div>
<br/>

<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3>{{ trans('left_menu.teacher') }}</h3>
        <ul class="nav side-menu metismenu" id="menu">
            <li {!! (Request::is('/') ? 'class="active" id="active" id="active"' : '') !!}>
                <a href="{{url('/')}}">
                    <i class="menu-icon fa fa-fw fa-dashboard text-default"></i>
                    <span class="mm-text ">{{ trans('secure.dashboard') }}</span>
                </a>
            </li>
            @if(isset($head_teacher) && $head_teacher > 0)
            <li {!! ((starts_with(Route::current()->uri, 'attendances_for_section')) ? 'class="active" id="active" id="active"' : '') !!}>
                <a href="{{url('/attendances_for_section')}}">
                    <i class="menu-icon fa fa-fw fa-list text-defaults"></i>
                    <span class="mm-text ">{{ trans('left_menu.attendances_for_section') }}</span>
                </a>
            </li>
            @endif
            <li {!! ((starts_with(Route::current()->uri, 'teachergroup') &&
                !starts_with(Route::current()->uri, 'teachergroup/timetable')) ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/teachergroup')}}">
                    <i class="menu-icon fa fa-list-alt text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.mygroups') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'teachergroup/timetable') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/teachergroup/timetable')}}">
                    <i class="menu-icon fa fa-calendar text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.timetable') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'notice') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/notice')}}">
                    <i class="menu-icon fa fa-paper-plane text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.notice') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'exam') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/exam')}}">
                    <i class="menu-icon fa fa-file-excel-o text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.exams') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'study_material') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/study_material')}}">
                    <i class="menu-icon fa fa-magic text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.study_material') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'subject_question') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/subject_question')}}">
                    <i class="menu-icon fa fa-list text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.subject_question') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'online_exam') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/online_exam')}}">
                    <i class="menu-icon fa fa-question-circle text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.online_exam') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'teacherstudent') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/teacherstudent')}}">
                    <i class="menu-icon fa fa-users text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.students') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'mark') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/mark')}}">
                    <i class="menu-icon fa fa-list-ol text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.marks') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'diary')? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/diary')}}">
                    <i class="menu-icon fa fa-comment text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.diary') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'attendance') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/attendance')}}">
                    <i class="menu-icon fa fa-exchange text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.attendances') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'applyingleave') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/applyingleave')}}">
                    <i class="menu-icon fa fa-external-link text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.applying_leave') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'transportation') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/transportation')}}">
                    <i class="menu-icon fa fa-compass text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.transportation') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'report/index') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/report/index')}}">
                    <i class="menu-icon fa fa-flag-checkered text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.reports') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'bookuser/index') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/bookuser/index')}}">
                    <i class="menu-icon fa fa-book text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.books') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'borrowedbook/index') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/borrowedbook/index')}}">
                    <i class="menu-icon fa fa-list text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.borrowed_books') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'staff_leave') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/staff_leave')}}">
                    <i class="menu-icon fa fa-level-up text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.staff_leave') }}</span>
                </a>
            </li>
            <li {!! (ends_with(Route::current()->uri, 'meal_table') ? 'class="active"' : '') !!}>
                <a href="{{url('/meal_table')}}">
                    <i class="menu-icon fa fa-cutlery text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.meal_table') }}</span>
                </a>
            </li>
        </ul>
    </div>
</div>