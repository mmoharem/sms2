@extends('layouts.secure')
@section('content')
    <style>
        a.list-group-item-success {
            color: #000000 !important;
        }
    </style>
    <div class="row">
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon">
                    <i class="fa fa-list-alt fa-1x"></i>
                </div>
                <div class="count"><span id="teachergroups"></span></div>
                <h3>{{trans('dashboard.teachergroups')}}</h3>
            </div>
        </div>
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon">
                    <i class="fa fa-list fa-1x"></i>
                </div>
                <div class="count"><span id="subjects"></span></div>
                <h3>{{trans('dashboard.subjects')}}</h3>
            </div>
        </div>
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon">
                    <i class="fa fa-comment fa-1x"></i>
                </div>
                <div class="count"><span id="diaries"></span></div>
                <h3>{{trans('dashboard.diaries')}}</h3>
            </div>
        </div>
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon">
                    <i class="fa fa-file-excel-o fa-1x"></i>
                </div>
                <div class="count"><span id="exams"></span></div>
                <h3>{{trans('dashboard.exams')}}</h3>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6 col-xs-12">
            <h1>{{trans('dashboard.calendar')}}</h1>
            <div id="calendar"></div>
        </div>
        <div class="col-sm-6 col-xs-12">
            <div class="row">
                <div class="col-sm-6">
                    <div class="animated flipInY">
                        <div class="tile-stats">
                            <div class="count"><span id="apply_leave_days"></span></div>
                            <h3>{{trans('dashboard.apply_leave_days')}}</h3>
                            @if($apply_leave_days < $apply_leave_total)
                                <button type="button" class="btn btn-primary btn-sm btn-sm bootstrap-modal-form-open" data-toggle="modal"
                                        data-target="#newLeaveDay">
                                    {{trans('dashboard.apply_leave')}}
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="animated flipInY">
                        <div class="tile-stats">
                            <div class="count"><span id="apply_leave_total"></span></div>
                            <h3>{{trans('dashboard.apply_leave_total')}}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <h1>{{trans('dashboard.teachergroups')}}</h1>
            <ul class="list-group">
                @foreach($teachergroups->get() as $group)
                    <a href="{{url('teachergroup/'.$group->id.'/show')}}"
                       class="list-group-item list-group-item-success">
                        {{$group->student_group->title}}
                    </a>
                @endforeach
            </ul>
            <h1>{{trans('dashboard.attendances_count')}}</h1>
            <div id="attendances_count"></div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6 col-xs-12">
            @if(count($faq_categories))
                <div class="panel-group" id="accordion">
                    @foreach($faq_categories as $key => $faq_grp)
                        <h3>{{$faq_grp->title}}</h3>
                        @foreach($faqs as $faq)
                            @if($faq_grp->id == $faq->faq_category_id)
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">{{$key+1}}.
                                            <a data-toggle="collapse" data-parent="#accordion" href="#faq{{$faq->id}}">
                                                {{$faq->title}}
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="faq{{$faq->id}}" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            {{$faq->content}}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    @include('modal_forms.apply_leave')
@stop
@section('scripts')
    <link rel="stylesheet" href="{{ asset('css/c3.min.css') }}">
    <script type="text/javascript" src="{{ asset('js/d3.v3.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/d3.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/c3.min.js')}}"></script>
    <script src="{{ asset('js/countUp.min.js') }}" type="text/javascript"></script>
    <script>
        $(function () {
            var useOnComplete = false,
                useEasing = false,
                useGrouping = false,
                options = {
                    useEasing: useEasing, // toggle easing
                    useGrouping: useGrouping, // 1,000,000 vs 1000000
                    separator: ',', // character to use as a separator
                    decimal: '.' // character to use as a decimal
                };
            var teachergroups = new CountUp("teachergroups", 0, "{{$teachergroups->get()->count()}}", 0, 3, options);
            teachergroups.start();
            var subjects = new CountUp("subjects", 0, "{{$subjects}}", 0, 3, options);
            subjects.start();
            var diaries = new CountUp("diaries", 0, "{{$diaries}}", 0, 3, options);
            diaries.start();
            var exams = new CountUp("exams", 0, "{{$exams}}", 0, 3, options);
            exams.start();
            var apply_leave_days = new CountUp("apply_leave_days", 0, "{{$apply_leave_days}}", 0, 3, options);
            apply_leave_days.start();
            var apply_leave_total = new CountUp("apply_leave_total", 0, "{{$apply_leave_total}}", 0, 3, options);
            apply_leave_total.start();
        });
        $(document).ready(function () {
            $('#calendar').fullCalendar({
                "header": {
                    "left": "prev,next today",
                    "center": "title",
                    "right": "month,agendaWeek,agendaDay"
                },
                "eventLimit": true,
                "firstDay": 1,
                "eventRender": function (event, element) {
                    element.popover({
                        content: event.description,
                        template: '<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
                        title: event.title,
                        container: 'body',
                        trigger: 'click',
                        placement: 'right'
                    });
                },
                "eventSources": [
                    {
                        url: "{{url('events')}}",
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        error: function () {
                            alert('there was an error while fetching events!');
                        }
                    }
                ]
            });
        });
        var chart = c3.generate({
            bindto: '#attendances_count',
            data: {
                columns: [
                        @foreach($attendances_count as $item)
                    ['{{$item['title']}}', {{$item['count']}}],
                    @endforeach
                ],
                type: 'pie',
                colors: {
                    @foreach($attendances_count as $item)
                    '{{$item['title']}}': get_random_color(),
                    @endforeach
                },
                labels: true
            },
            pie: {
                label: {
                    format: function (value, ratio, id) {
                        return d3.format('')(value);
                    }
                }
            }
        });
        function get_random_color() {
            function c() {
                var hex = Math.floor(Math.random() * 256).toString(16);
                return ("0" + String(hex)).substr(-2); // pad with zero
            }

            return "#" + c() + c() + c();
        }
    </script>
@stop
