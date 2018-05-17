<div class="profile">
    <br/>
</div><br/>

<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3>{{ trans('left_menu.human_resources') }}</h3>
        <ul class="nav side-menu metismenu" id="menu">
            <li {!! (Request::is('/') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/')}}">
                    <i class="menu-icon fa fa-fw fa-dashboard text-default"></i>
                    <span class="mm-text ">{{ trans('secure.dashboard') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'parent') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/parent')}}">
                    <i class="menu-icon fa fa-user-md text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.parents') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'teacher') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/teacher')}}">
                    <i class="menu-icon fa fa-user-secret text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.teachers') }}</span>
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
            <li {!! (ends_with(Route::current()->uri, 'doorman') ? 'class="active"' : '') !!}>
                <a href="{{url('/doorman')}}">
                    <i class="menu-icon fa fa-arrows text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.doormans') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'staff_attendance') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/staff_attendance')}}">
                    <i class="menu-icon fa fa-taxi text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.staff_attendance') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'staff_leave') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/staff_leave')}}">
                    <i class="menu-icon fa fa-level-up text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.staff_leave') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'salary') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/salary')}}">
                    <i class="menu-icon fa fa-credit-card text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.salary') }}</span>
                </a>
            </li>
            <li {!! (ends_with(Route::current()->uri, 'meal_table') ? 'class="active"' : '') !!}>
                <a href="{{url('/meal_table')}}">
                    <i class="menu-icon fa fa-cutlery text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.meal_table') }}</span>
                </a>
            </li>
            <li {!! (ends_with(Route::current()->uri, 'teacher_duty') ? 'class="active"' : '') !!}>
                <a href="{{url('/teacher_duty')}}">
                    <i class="menu-icon fa fa-angle-double-up text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.teacher_duty') }}</span>
                </a>
            </li>
        </ul>
    </div>
</div>