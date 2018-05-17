<div class="profile">
    <br/>
</div><br/>
<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3>{{ trans('left_menu.accountant') }}</h3>
        <ul class="nav side-menu metismenu" id="menu">
            <li {!! (Request::is('/') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/')}}">
                    <i class="menu-icon fa fa-fw fa-dashboard text-default"></i>
                    <span class="mm-text ">{{ trans('secure.dashboard') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'account') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/account')}}">
                    <i class="menu-icon fa fa-credit-card text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.account') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'account_type') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/account_type')}}">
                    <i class="menu-icon fa fa-credit-card text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.account_type') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'voucher') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/voucher')}}">
                    <i class="menu-icon fa fa-credit-card text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.voucher') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'invoice') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/invoice')}}">
                    <i class="menu-icon fa fa-credit-card text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.invoice') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'debtor') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/debtor')}}">
                    <i class="menu-icon fa fa-money text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.debtor') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'payment') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/payment')}}">
                    <i class="menu-icon fa fa-money text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.payment') }}</span>
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
            <li {!! (starts_with(Route::current()->uri, 'return_book_penalty') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/return_book_penalty')}}">
                    <i class="menu-icon fa fa-bookmark text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.return_book_penalty') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'expense_category') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/expense_category')}}">
                    <i class="menu-icon fa fa-credit-card text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.expense_category') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'expense/') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/expense')}}">
                    <i class="menu-icon fa fa-credit-card text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.expense') }}</span>
                </a>
            </li>
            <li {!! (starts_with(Route::current()->uri, 'scholarship') ? 'class="active" id="active"' : '') !!}>
                <a href="{{url('/scholarship')}}">
                    <i class="menu-icon fa fa-gift text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.scholarship') }}</span>
                </a>
            </li>
            <li {!! (ends_with(Route::current()->uri, 'meal_table') ? 'class="active"' : '') !!}>
                <a href="{{url('/meal_table')}}">
                    <i class="menu-icon fa fa-cutlery text-default"></i>
                    <span class="mm-text">{{ trans('left_menu.meal') }}</span>
                </a>
            </li>
        </ul>
    </div>
</div>