<div class="profile">
    <br/>
</div><br/>

<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3>{{ trans('left_menu.supplier') }}</h3>
        <ul class="nav side-menu metismenu" id="menu">
            <li {!! (Request::is('/') ? 'class="active" id="active" id="active"' : '') !!}>
                <a href="{{url('/')}}">
                    <i class="menu-icon fa fa-fw fa-dashboard text-default"></i>
                    <span class="mm-text ">{{ trans('secure.dashboard') }}</span>
                </a>
            </li>
        </ul>
    </div>
</div>