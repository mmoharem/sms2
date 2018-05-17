@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    {{trans('studentgroup.timetable_info')}}
    {!! Form::label('student_group', $studentGroup->title, array('class' => 'control-label')) !!}
    @if(isset($subject_list[0]))
        <div class="row">
            <div class="col-sm-10">
                <div class="box-body">
                    <table class="table table-bordered no-padding">
                        <tbody>
                        <tr>
                            <th>#</th>
                            <th width="14%">{{trans('studentgroup.monday')}}</th>
                            <th width="14%">{{trans('studentgroup.tuesday')}}</th>
                            <th width="14%">{{trans('studentgroup.wednesday')}}</th>
                            <th width="14%">{{trans('studentgroup.thursday')}}</th>
                            <th width="14%">{{trans('studentgroup.friday')}}</th>
                            <th width="14%">{{trans('studentgroup.saturday')}}</th>
                            <th width="14%">{{trans('studentgroup.sunday')}}</th>
                        </tr>
                        @if($timetablePeriods->count() >0 )
                            @foreach($timetablePeriods as $timetablePeriod)
                                <tr>
                                    <td>{{$timetablePeriod->start_at.' - '. $timetablePeriod->end_at}}</td>
                                    @for($j=1;$j<8;$j++)
                                        @if($timetablePeriod->title=="")
                                            <td id="{{ $j.'-'.$timetablePeriod->id.'-0' }}"
                                                class="droppable timetable_table">
                                                @foreach($timetable as $item)
                                                    @if($item['week_day']==$j && $item['hour']==$timetablePeriod->id)
                                                        <div class="btn btn-info">
                                                            <span>{{((strlen($item['subject_short_name'])>2)?$item['subject_short_name']:$item['title'])}}</span>
                                                            <br>
                                                            <span>{{((strlen($item['teacher_short_name'])>2)
                                        ?$item['teacher_short_name']:$item['name'])}}</span>
                                                            <a id="{{$item['id']}}" class="trash"><i
                                                                        class="fa fa-trash-o btn btn-danger btn-sm btn-sm"></i></a>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </td>
                                        @else
                                            <td class="droppable timetable_table">
                                                {{$timetablePeriod->title}}
                                            </td>
                                        @endif
                                    @endfor
                                </tr>
                            @endforeach
                        @else
                            @for($i=1;$i<8;$i++)
                                <tr>
                                    <td>{{$i}}</td>
                                    @for($j=1;$j<8;$j++)
                                        <td id="{{$j}}-{{$i}}" class="droppable timetable_table">
                                            @foreach($timetable as $item)
                                                @if($item['week_day']==$j && $item['hour']==$i)
                                                    <div class="btn btn-default">
                                                        <span>{{((strlen($item['subject_short_name'])>2)?$item['subject_short_name']:$item['title'])}}</span>
                                                        <br>
                                                        <span>{{((strlen($item['teacher_short_name'])>2)
                                        ?$item['teacher_short_name']:$item['name'])}}</span>
                                                        <a id="{{$item['id']}}" class="trash"><i
                                                                    class="fa fa-trash-o btn btn-danger btn-sm btn-sm"></i></a>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </td>
                                    @endfor
                                </tr>
                            @endfor
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-sm-2">
                <ul class="list-group">
                    @if(isset($subject_list ))
                        @foreach($subject_list as $item)
                            <li class="list-group-item timetable">
                                <div class="draggable" id="{{$item['id']}}">
                                    <span>{{((strlen($item['subject_short_name'])>2)?$item['subject_short_name']:$item['title'])}}</span>
                                    <br>
                                    <span>{{((strlen($item['teacher_short_name'])>2)
                                            ?$item['teacher_short_name']:$item['name'])}}</span>
                                </div>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
        <div class="form-group">
            <div class="controls">
                <a href="{{ url('/section/'.$section->id.'/groups') }}"
                   class="btn btn-warning btn-sm">{{trans('table.back')}}</a>
                <a href="{{ url('/studentgroup/'.$section->id.'/'.$studentGroup->id.'/0/print_timetable') }}"
                   target="_blank"
                   class="btn btn-info btn-sm"><i class="fa fa-print" aria-hidden="true"></i> {{trans('table.print')}}
                </a>
            </div>
        </div>
        {!! Form::close() !!}
    @else
        @if(isset($subject_list ))
            @foreach($subject_list as $id=>$subject_collection)
                @if(isset($semesters[$id]))
                    <br> {{$semesters[$id]->title}}
                @endif
                <div class="row">
                    <div class="col-sm-10">
                        <div class="box-body">
                            <table class="table table-bordered no-padding">
                                <tbody>
                                <tr>
                                    <th>#</th>
                                    <th width="14%">{{trans('studentgroup.monday')}}</th>
                                    <th width="14%">{{trans('studentgroup.tuesday')}}</th>
                                    <th width="14%">{{trans('studentgroup.wednesday')}}</th>
                                    <th width="14%">{{trans('studentgroup.thursday')}}</th>
                                    <th width="14%">{{trans('studentgroup.friday')}}</th>
                                    <th width="14%">{{trans('studentgroup.saturday')}}</th>
                                    <th width="14%">{{trans('studentgroup.sunday')}}</th>
                                </tr>
                                @if($timetablePeriods->count() >0 )
                                    @foreach($timetablePeriods as $timetablePeriod)
                                        <tr>
                                            <td>{{$timetablePeriod->start_at.' - '. $timetablePeriod->end_at}}</td>
                                            @for($j=1;$j<8;$j++)
                                                @if($timetablePeriod->title=="")
                                                    <td id="{{ $j.'-'.$timetablePeriod->id.'-'.$semesters[$id]->id }}"
                                                        class="droppable timetable_table">
                                                        @foreach($timetable[$id] as $item)
                                                            @if($item['week_day']==$j && $item['hour']==$timetablePeriod->id)
                                                                <div class="btn btn-info">
                                                                    <span>{{((strlen($item['subject_short_name'])>2)?$item['subject_short_name']:$item['title'])}}</span>
                                                                    <br>
                                                                    <span>{{((strlen($item['teacher_short_name'])>2)
                                        ?$item['teacher_short_name']:$item['name'])}}</span>
                                                                    <a id="{{$item['id']}}" class="trash"><i
                                                                                class="fa fa-trash-o btn btn-danger btn-sm btn-sm"></i></a>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                @else
                                                    <td class="droppable timetable_table">
                                                        {{$timetablePeriod->title}}
                                                    </td>
                                                @endif
                                            @endfor
                                        </tr>
                                    @endforeach
                                @else
                                    @for($i=1;$i<8;$i++)
                                        <tr>
                                            <td>{{$i}}</td>
                                            @for($j=1;$j<8;$j++)
                                                <td id="{{$j}}-{{$i}}" class="droppable timetable_table">
                                                    @foreach($timetable[$id] as $item)
                                                        @if($item['week_day']==$j && $item['hour']==$i)
                                                            <div class="btn btn-default">
                                                                <span>{{((strlen($item['subject_short_name'])>2)?$item['subject_short_name']:$item['title'])}}</span>
                                                                <br>
                                                                <span>{{((strlen($item['teacher_short_name'])>2)
                                        ?$item['teacher_short_name']:$item['name'])}}</span>
                                                                <a id="{{$item['id']}}" class="trash"><i
                                                                            class="fa fa-trash-o btn btn-danger btn-sm btn-sm"></i></a>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </td>
                                            @endfor
                                        </tr>
                                    @endfor
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <ul class="list-group">
                            @foreach($subject_collection as $item)
                                <li class="list-group-item timetable">
                                    <div class="draggable" id="{{$item['id']}}">
                                        <span>{{((strlen($item['subject_short_name'])>2)?$item['subject_short_name']:$item['title'])}}</span>
                                        <br>
                                        <span>{{((strlen($item['teacher_short_name'])>2)
                                        ?$item['teacher_short_name']:$item['name'])}}</span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="form-group">
                    <div class="controls">
                        <a href="{{ url('/section/'.$section->id.'/groups') }}"
                           class="btn btn-warning btn-sm">{{trans('table.back')}}</a>
                        <a href="{{ url('/studentgroup/'.$section->id.'/'.$studentGroup->id.'/'.$semesters[$id]->id.'/print_timetable') }}"
                           target="_blank"
                           class="btn btn-info btn-sm"><i class="fa fa-print"
                                                          aria-hidden="true"></i> {{trans('table.print')}}</a>
                    </div>
                </div>
                {!! Form::close() !!}
            @endforeach
        @endif
    @endif
@stop

@section('scripts')
    <script>
        $('body').toggleClass('nav-md nav-sm');
        $(document).ready(function () {
            $(function () {
                $(".draggable").draggable({
                    cursor: "move",
                    helper: "clone",
                    revert: "invalid"
                });
                $(".droppable").droppable({
                    accept: '.draggable',
                    hoverClass: "ui-state-hover",
                    drop: function (event, ui) {
                        var draggable = parseInt(ui.draggable.attr("id"));
                        var droppable_contener = $(this);
                        var droppable = $(this).attr('id').split('-');
                        $.ajax({
                            type: "POST",
                            url: '{{ url('/studentgroup/'.$section->id.'/'.$studentGroup->id.'/addtimetable') }}',
                            data: {
                                _token: '{{ csrf_token() }}',
                                teacher_subject_id: draggable,
                                week_day: parseInt(droppable[0]),
                                hour: parseInt(droppable[1]),
                                semester_id: parseInt(droppable[2])
                            },
                            success: function (response) {
                                var div_html = $('div[id="' + draggable + '"]').clone().removeClass('draggable droppable ui-droppable').html();
                                droppable_contener.append('<div class="btn btn-success btn-sm">' + div_html + '<a class="trash" id="' + response + '"><i class="fa fa-trash-o btn btn-danger btn-sm btn-sm"></i></a></div>');
                                $('a.trash').click(function () {
                                    var trash = $(this);
                                    $.ajax({
                                        type: "DELETE",
                                        url: '{{ url('/studentgroup/'.$section->id.'/'.$studentGroup->id.'/deletetimetable') }}',
                                        data: {_token: '{{ csrf_token() }}', id: trash.attr("id")},
                                        success: function () {
                                            trash.parent().remove();
                                        }
                                    });
                                });
                            }
                        });
                    }
                });
                $('a.trash').click(function () {
                    var trash = $(this);
                    $.ajax({
                        type: "DELETE",
                        url: '{{ url('/studentgroup/'.$section->id.'/'.$studentGroup->id.'/deletetimetable') }}',
                        data: {_token: '{{ csrf_token() }}', id: trash.attr("id")},
                        success: function () {
                            trash.parent().remove();
                        }
                    });
                });
            });
        });
    </script>
@endsection

