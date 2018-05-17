<div class="profile">
    <br/>
</div><br/>

<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3>{{ trans('left_menu.kitchen_staff') }}</h3>
        <ul class="nav side-menu metismenu" id="menu">
            <li {!! (Request::is('/') ? 'class="active" id="active" id="active"' : '') !!}>
                <a href="{{url('/')}}">
                    <i class="menu-icon fa fa-fw fa-dashboard text-default"></i>
                    <span class="mm-text ">{{ trans('secure.dashboard') }}</span>
                </a>
            </li>
            <li {!! (ends_with(Route::current()->uri, 'meal') ? 'class="active"' : '') !!}>
                <a href="{{url('/meal')}}">
                    <i class="menu-icon fa fa-apple text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.meal') }}</span>
                </a>
            </li>
            <li {!! (ends_with(Route::current()->uri, 'meal_table') ? 'class="active"' : '') !!}>
                <a href="{{url('/meal_table')}}">
                    <i class="menu-icon fa fa-cutlery text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.meal_table') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'staff_leave') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/staff_leave')}}">
                    <i class="menu-icon fa fa-level-up text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.staff_leave') }}</span>
                </a>
            </li>
        </ul>
    </div>
</div>