<li role="presentation" class="dropdown">
    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        <img src="{{ url($user->picture) }}" alt="">{{ str_limit($user->full_name_title, 25) }}
        <span class=" fa fa-angle-down"></span>
    </a>
    <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
        <li><a href="{{ url('/profile') }}">
                <i class="fa fa-fw fa-user"></i>
                {{trans('auth.my_profile')}}
            </a>
        </li>
        @if($user->inRole('student'))
            <li><a href="{{ url('/my_certificate') }}">
                    <i class="fa fa-fw fa-certificate"></i>
                    {{trans('auth.my_certificate')}}
                </a>
            </li>
        @endif
        @if($user->inRole('super_admin') || $user->inRole('admin_super_admin'))
            <li><a href="{{ url('/release_license') }}">
                    <i class="fa fa-fw fa-code-fork"></i>
                    {{trans('release_license.release_license')}}
                </a>
            </li>
        @endif
        <li><a href="{{ url('logout') }}"><i class="fa fa-sign-out pull-right"></i> {{trans('auth.logout')}}</a></li>
    </ul>
</li>
<li role="presentation" class="dropdown">
    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        <i class="fa fa-envelope-o"></i>
        <span class="badge bg-blue">{{ isset($new_emails)?$new_emails->count():"0" }}</span>
    </a>
    <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
        <li>{{trans('dashboard.you_have'). (isset($new_emails)?$new_emails->count():"0").trans('dashboard.new_emails')}}.</li>
        @if(isset($new_emails))
            @foreach($new_emails as $item)
            <li>
                <a href="{{ url('mailbox/'.$item->id.'/replay') }}" class="message striped-col">
                    <img src="{{$item->sender->picture}}"
                         class="message-image  col-sm-3 img-circle" alt="image"/>
                    <div class="message-body">
                        <strong>{{ str_limit($item->sender->full_name, 50) }}</strong>
                        <br>
                        {{ str_limit($item->subject,50) }}
                        <br>
                        <small>{{ $item->created_at->format(Settings::get('date_format').' '.Settings::get('time_format')) }}</small>
                        <span class="label label-success label-mini msg-lable">New</span>
                    </div>
                </a>
            </li>
            @endforeach
        @endif
        <li>
            <a href="{{ url('mailbox') }}">
                <strong>{{trans('dashboard.view_messages')}} </strong>
                <i class="fa fa-angle-right"></i>
            </a>
        </li>
    </ul>
</li>
@if(isset($schools) && (!($user->inRole('super_admin'))))
    <li role="presentation" class="dropdown">
        <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-university"></i>
            <span class="badge bg-blue">{{$current_school_item}}</span>
        </a>
        <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
            @foreach($schools as $item)
                <li>
                    <a href="{{url('/setschool/'.$item->id)}}">
                        <i class="menu-icon fa fa-university
                            {{ (($item->id==$current_school)?"text-success": "text-warning") }}">
                        </i>
                        {{ $item->title }}
                    </a>
                </li>
            @endforeach
            <li class="dropdown-footer">
                <a href="{{url('/schools')}}">
                    <strong>{{trans('secure.view_all')}} </strong>
                    <i class="fa fa-angle-right"></i></a>
            </li>
        </ul>
    </li>
@endif
@if(isset($current_student_section))
    <li role="presentation" class="dropdown">
        <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-graduation-cap"></i>
            <span class="badge bg-blue">{{$current_student_section}}</span>
        </a>
    </li>
@endif
@if(isset($student_groups))
    <li role="presentation" class="dropdown">
        <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-edit"></i>
            <span class="badge bg-blue">{{$current_student_group}}</span>
        </a>
        <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
            @foreach($student_groups as $group)
                <li>
                    <a href="{{url('/setgroup/'.$group->id)}}">
                        <i class="menu-icon fa fa-users
                            {{ (($group->id==$current_student_group_id)?"text-success": "text-warning") }}">
                        </i>
                        {{ $group->title }}
                    </a>
                </li>
            @endforeach
            <li class="dropdown-footer">
                <a href="{{url('/teachergroup')}}">
                    <strong>{{trans('secure.view_all')}} </strong>
                    <i class="fa fa-angle-right"></i></a>
            </li>
        </ul>
    </li>
@endif
@if(isset($student_ids))
    <li role="presentation" class="dropdown">
        <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-graduation-cap"></i>
            <span class="badge bg-blue">{{$current_student_name}}</span>
        </a>
        <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
            @foreach($student_ids as $student)
                <li>
                    <a href="{{url('/setstudent/'.$student->id)}}">
                        <i class="menu-icon fa fa-users
                           {{ (($student->id==$current_student_id)?"text-success": "text-warning") }}">
                        </i>
                        {{ $student->name }}
                    </a>
                </li>
            @endforeach
            <li class="dropdown-footer">
                <a href="{{url('/parentsection')}}">
                    <strong>{{trans('secure.view_all')}} </strong>
                    <i class="fa fa-angle-right"></i></a>
            </li>
        </ul>
    </li>
@endif
@if(isset($school_years))
    <li role="presentation" class="dropdown">
        <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-calendar"></i>
            <span class="badge bg-blue">{{$current_school_year}}</span>
        </a>
        <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
            @foreach($school_years as $year)
                <li>
                    <a href="{{url('/setyear/'.$year->id)}}">
                        <i class="menu-icon fa fa-calendar
                           {{ (($year->id==$current_school_year_id)?"text-success": "text-warning") }}">
                        </i>
                        {{ $year->title }}
                    </a>
                </li>
            @endforeach
            @if ($user->inRole('super_admin') || $user->inRole('admin_super_admin'))
                <li class="dropdown-footer">
                        <a href="{{url('/schoolyear')}}">
                            <strong>{{trans('secure.view_all')}} </strong>
                            <i class="fa fa-angle-right"></i></a>
                    </li>
            @endif
        </ul>
    </li>
@endif
@if(count(config('languages')) > 1)
    <li role="presentation" class="dropdown">
        <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-globe"></i>
            <span class="badge bg-blue">{{App::getLocale()}}</span>
        </a>
        <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
            @foreach (config('languages') as $lang => $language)
                @if ($lang != App::getLocale())
                    <li>
                        <a href="{{ url('change-lang', $lang) }}">
                            {{$language}}
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </li>
@endif