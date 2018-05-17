<div class="profile">
    <br/>
</div><br/>

<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3>{{ trans('left_menu.visitor') }}</h3>
        <ul class="nav side-menu metismenu" id="menu">
            <li {!! (Request::is('/') ? 'class="active" id="active" id="active"' : '') !!}>
                <a href="{{url('/')}}">
                    <i class="menu-icon fa fa-fw fa-dashboard text-default"></i>
                    <span class="mm-text ">{{ trans('secure.dashboard') }}</span>
                </a>
            </li>
            <li {!! ((starts_with(Route::current()->uri, 'visitor') && !starts_with(Route::current()->uri, 'visitor_visit')) ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/visitor')}}">
                    <i class="menu-icon fa fa-user text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.visitors') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'visitor_visit') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/visitor_visit')}}">
                    <i class="menu-icon fa fa-exchange text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.visitor_visits') }}</span>
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