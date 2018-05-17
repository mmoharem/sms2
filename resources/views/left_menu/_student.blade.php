<div class="profile">
    <br/>
</div><br/>

<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3>{{ trans('left_menu.student') }}</h3>
        <ul class="nav side-menu metismenu" id="menu">
            <li {!! (Request::is('/') ? 'class="active" id="active" id="active"' : '') !!}>
                <a href="{{url('/')}}">
                    <i class="menu-icon fa fa-fw fa-dashboard text-default"></i>
                    <span class="mm-text ">{{ trans('secure.dashboard') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'student_card') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/student_card/'.$current_student_id)}}" target="_blank">
                    <i class="menu-icon fa fa-credit-card text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.student_card') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'studentsection/timetable') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/studentsection/timetable')}}">
                    <i class="menu-icon fa fa-calendar text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.timetable') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'studentsection/subjects') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/studentsection/subjects')}}">
                    <i class="menu-icon fa fa-list text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.subjects') }}</span>
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
            <li {!! (ends_with(Route::current()->uri, 'notice') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/report/'.$user->id.'/notice')}}">
                    <i class="menu-icon fa fa-paper-plane text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.notice') }}</span>
                </a>
            </li>
            <li {!! (ends_with(Route::current()->uri, 'online_exams') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/report/'.$user->id.'/online_exams')}}">
                    <i class="menu-icon fa fa-question-circle text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.online_exam') }}</span>
                </a>
            </li>
            <li {!! (ends_with(Route::current()->uri, 'attendances') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/report/'.$user->id.'/attendances')}}">
                    <i class="menu-icon fa fa-exchange text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.attendances') }}</span>
                </a>
            </li>
            <li {!! (ends_with(Route::current()->uri, 'marks') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/report/'.$user->id.'/marks')}}">
                    <i class="menu-icon fa fa-list-ol text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.marks') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'exams') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/report/'.$user->id.'/exams')}}">
                    <i class="menu-icon fa fa-file-excel-o text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.exams') }}</span>
                </a>
            </li>
            <li {!! (ends_with(Route::current()->uri, 'subjectbook') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/report/'.$user->id.'/subjectbook')}}">
                    <i class="menu-icon fa fa-list-alt text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.subjectbook') }}</span>
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
            <li {!! (starts_with(Route::current()->uri, 'diary') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/diary')}}">
                    <i class="menu-icon fa fa-comment text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.diary') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'studentsection/payment')  ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/studentsection/payment')}}">
                    <i class="menu-icon fa fa-money text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.payments') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'studentsection/invoice') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/studentsection/invoice')}}">
                    <i class="menu-icon fa fa-credit-card text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.invoice') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'transportation') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/transportation')}}">
                    <i class="menu-icon fa fa-compass text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.transportation') }}</span>
                </a>
            </li>
            <li {!! (ends_with(Route::current()->uri, 'forstudent') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/report/'.$user->id.'/forstudent')}}">
                    <i class="menu-icon fa fa-flag-checkered text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.reports') }}</span>
                </a>
            </li>
            <li {!! (ends_with(Route::current()->uri, 'meal_table') ? 'class="active"' : '') !!}>
                <a href="{{url('/meal_table')}}">
                    <i class="menu-icon fa fa-cutlery text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.meal_table') }}</span>
                </a>
            </li>
            <li {!! (ends_with(Route::current()->uri, 'teacher_duty_table') ? 'class="active"' : '') !!}>
                <a href="{{url('/teacher_duty_table')}}">
                    <i class="menu-icon fa fa-angle-double-up text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.teacher_duty') }}</span>
                </a>
            </li>
        </ul>
    </div>
</div>