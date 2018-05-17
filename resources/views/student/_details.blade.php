<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <div class="form-group">
                    <label class="control-label" for="title">{{trans('student.first_name')}}</label>
                    <div class="controls">
                        @if (isset($student)) {{ $student->user->first_name }} @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="title">{{trans('student.last_name')}}</label>
                    <div class="controls">
                        @if (isset($student)) {{ $student->user->last_name }} @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="title">{{trans('student.email')}}</label>
                    <div class="controls">
                        @if (isset($student)) {{ $student->user->email }} @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="title">{{trans('student.gender')}}</label>
                    <div class="controls">
                        @if (isset($student)) {{ ($student->user->gender=='1')?trans('student.male'):trans('student.female') }} @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="title">{{trans('student.order')}}</label>
                    <div class="controls">
                        @if (isset($student)) {{ $student->order }} @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="title">{{trans('student.section')}}</label>
                    <div class="controls">
                        @if (isset($student->section)) {{ $student->section->title }} @endif
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('user_avatar_file', trans('profile.avatar'), array('class' => 'control-label')) !!}
                    <div class="controls row">
                        <div class="col-sm-6">
                            <img src="{{ url($student->user->picture) }}" alt="User Image" class="img-thumbnail">
                        </div>
                    </div>
                </div>
                @if (isset($student->dormitory->title))
                    <div class="form-group">
                        <label class="control-label" for="title">{{trans('student.dormitory')}}</label>
                        <div class="controls">
                            {{ isset($student->dormitory->title)?$student->dormitory->title:"" }},
                            {{ isset($student->bed->dormitory_room->dormitory->title)?$student->bed->dormitory_room->dormitory->title:"" }}
                            ,
                            {{ isset($student->bed->dormitory_room->title)?$student->bed->dormitory_room->title:"" }}
                            {{ isset($student->bed->title)?", ".$student->bed->title:"" }}
                        </div>
                    </div>
                @endif
                @if($student->user->parents->count()>0)
                    <div class="form-group">
                        <label class="control-label" for="title">{{trans('student.parents')}}</label>
                        <div class="controls">
                            <ul>
                                @foreach($student->user->parents as $item)
                                    @if(isset($item->parent->full_name))
                                        <li>{{ $item->parent->full_name }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                @if(is_array($custom_fields))
                    @foreach($custom_fields as $item)
                        <div class="form-group">
                            <label class="control-label" for="title">{{ucfirst($item->name)}}</label>
                            <div class="controls">
                                {{ $item->value }}
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="col-lg-6 col-sm-12">
                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered datatables">
                    <tr>
                        <td><strong>{{trans('student.student_id')}}</strong></td>
                        <td>{{$student->student_no}}</td>
                        <td><strong>{{trans('student.section')}}</strong></td>
                        <td>{{$student->section->title}}</td>
                    </tr>
                    <tr>
                        <td><strong>{{trans('student.school_year')}}</strong></td>
                        <td>{{$student->school_year->title}}</td>
                        <td><strong>{{trans('student.date_enrolled')}}</strong></td>
                        <td>{{$student->created_at->toFormattedDateString()}}
                            ({{$student->created_at->diffForHumans()}})
                        </td>
                    </tr>
                    <tr>
                        <td><strong>{{trans('student.intakePeriod')}}</strong></td>
                        <td>{{isset($student->intakePeriod)?$student->intakePeriod->name:""}}</td>
                        <td><strong>{{trans('student.entry_mode')}}</strong></td>
                        <td>{{isset($student->user->entrymode)?$student->user->entrymode->name:""}}</td>
                    </tr>
                    <tr>
                        <td><strong>{{trans('student.levelOfAdmission')}}</strong></td>
                        <td>{{isset($student->admissionlevel->entrymode)?$student->admissionlevel->name:""}}</td>
                        <td><strong>{{trans('student.level')}}</strong></td>
                        <td>{{isset($student->level)?$student->level->name:""}}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="controls">
            @if (@$action == 'show')
                <a href="{{ url($type) }}" class="btn btn-primary btn-sm">{{trans('table.close')}}</a>
            @else
                <a href="{{ url($type) }}" class="btn btn-primary btn-sm">{{trans('table.cancel')}}</a>
                <button type="submit" class="btn btn-danger btn-sm">{{trans('table.delete')}}</button>
            @endif
        </div>
    </div>
</div>