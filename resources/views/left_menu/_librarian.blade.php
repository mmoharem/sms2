<div class="profile">
    <br/>
</div><br/>/>

<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3>{{ trans('left_menu.librarian') }}</h3>
        <ul class="nav side-menu metismenu" id="menu">
            <li {!! (Request::is('/') ? 'class="active" id="active" id="active"' : '') !!}>
                <a href="{{url('/')}}">
                    <i class="menu-icon fa fa-fw fa-dashboard text-default"></i>
                    <span class="mm-text ">{{ trans('secure.dashboard') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'book') &&
            !starts_with(Route::current()->uri, 'booklibrarian')? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/book')}}">
                    <i class="menu-icon fa fa-book text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.books') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'booklibrarian') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/booklibrarian')}}">
                    <i class="menu-icon fa fa-list text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.issue_books') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'reservedbook') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/reservedbook')}}">
                    <i class="menu-icon fa fa-list-ol text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.reserved_books') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'task') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/task')}}">
                    <i class="menu-icon fa fa-thumb-tack text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.task') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'return_book_penalty') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/return_book_penalty')}}">
                    <i class="menu-icon fa fa-bookmark text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.return_book_penalty') }}</span>
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