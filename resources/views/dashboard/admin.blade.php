@extends('layouts.secure')
@section('content')
    <div class="row">
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon">
                    <i class="fa fa-server fa-1x"></i>
                </div>
                <div class="count"><span id="sections"></span></div>
                <h3>{{trans('dashboard.sections')}}</h3>
            </div>
        </div>
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon">
                    <i class="fa fa-user-md fa-1x"></i>
                </div>
                <div class="count"><span id="teachers"></span></div>
                <h3>{{trans('dashboard.teachers')}}</h3>
            </div>
        </div>
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon">
                    <i class="fa fa-user fa-1x"></i>
                </div>
                <div class="count"><span id="parents"></span></div>
                <h3>{{trans('dashboard.parents')}}</h3>
            </div>
        </div>
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon">
                    <i class="fa fa-arrows-alt fa-1x"></i>
                </div>
                <div class="count"><span id="directions"></span></div>
                <h3>{{trans('dashboard.directions')}}</h3>
            </div>
        </div>
    </div>
    @if(Settings::get('sms_driver')!=""  && Settings::get('sms_driver') !='none')
    <div class="row">
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon">
                    <i class="fa fa-mobile fa-1x"></i>
                </div>
                <div class="count"><span id="limit_sms_messages"></span></div>
                <h3>{{trans('schools.limit_sms_messages')}}</h3>
            </div>
        </div>
    </div>
    @endif

    <div class="row">
        <div class="col-sm-6 col-xs-12">
            <h1>{{trans('dashboard.calendar')}}</h1>
            <div id="calendar"></div>
        </div>
        <div class="col-sm-6 col-xs-12">
            <h1>{{trans('dashboard.salary_by_month')}}</h1>
            <div id="salary_by_month"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-xs-12">
            <h1>{{trans('dashboard.payments_by_month')}}</h1>
            <div id="payments_by_month"></div>
        </div>
        <div class="col-sm-6 col-xs-12">
            <h1>{{trans('dashboard.students_section_per_year')}}</h1>
            <div id="students_section_per_year"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-xs-12">
            <h1>{{trans('dashboard.students_gender')}}</h1>
            <div id="students_gender"></div>
        </div>
        <div class="col-sm-6 col-xs-12">
            <h1>{{trans('dashboard.teachers_gender')}}</h1>
            <div id="teachers_gender"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-xs-12">
            <h1>{{trans('dashboard.send_sms')}}</h1>
            <div id="send_sms"></div>
        </div>
        <div class="col-sm-6 col-xs-12">
            <h1>{{trans('dashboard.students_by_country')}}</h1>
            @include('charts.students_by_country')
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-xs-12">
            <h1>{{trans('dashboard.applicant_by_school_year')}}</h1>
            @include('charts.applicant_by_school_year')
        </div>
        <div class="col-sm-6 col-xs-12">
            <h1>{{trans('dashboard.students_by_school_year')}}</h1>
            @include('charts.students_by_school_year')
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

@stop
@section('scripts')
    <link rel="stylesheet" href="{{ asset('css/c3.min.css') }}">
    <script type="text/javascript" src="{{ asset('js/d3.v3.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/d3.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/c3.min.js')}}"></script>
    <script src="{{ asset('js/countUp.min.js') }}" type="text/javascript"></script>
    <script>
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
            var sections = new CountUp("sections", 0, "{{$sections->count()}}", 0, 3, options);
            sections.start();
            var teachers = new CountUp("teachers", 0, "{{$teachers}}", 0, 3, options);
            teachers.start();
            var parents = new CountUp("parents", 0, "{{$parents}}", 0, 3, options);
            parents.start();
            var directions = new CountUp("directions", 0, "{{$directions}}", 0, 3, options);
            directions.start();

            var limit_sms_messages = new CountUp("limit_sms_messages", 0, "{{(!is_null($school_list))?$school_list->limit_sms_messages:0}}", 0, 3, options);
            limit_sms_messages.start();

            var salary_by_month = [
                ['{{trans('dashboard.salary_by_month')}}'],
                    @foreach($per_month as $item)
                [{{$item['salary_by_month']}}],
                @endforeach
            ];
            var salary = c3.generate({
                bindto: '#salary_by_month',
                data: {
                    rows: salary_by_month,
                    type: 'area-spline'
                },
                color: {
                    pattern: ['#FD9883']
                },
                axis: {
                    x: {
                        tick: {
                            format: function (d) {
                                return formatMonth(d);
                            }
                        }
                    }
                },
                legend: {
                    show: true,
                    position: 'bottom'
                },
                padding: {
                    top: 10
                }
            });

            function formatMonth(d) {

                @foreach($per_month as $id => $item)
                if ('{{$id}}' == d) {
                    return '{{$item['month']}}' + ' ' + '{{$item['year']}}'
                }
                @endforeach
            }

            setTimeout(function () {
                salary.resize();
            }, 2000);

            setTimeout(function () {
                salary.resize();
            }, 4000);

            setTimeout(function () {
                salary.resize();
            }, 6000);
            $("[data-toggle='offcanvas']").click(function (e) {
                salary.resize();
            });

        });

        $(function () {
            var payments_by_month = [
                ['{{trans('dashboard.sum_of_payments')}}','{{trans('dashboard.sum_of_invoices')}}'],
                    @foreach($per_month as $item)
                [{{$item['sum_of_payments']}}, {{$item['sum_of_invoices']}}],
                @endforeach
            ];
            var payments = c3.generate({
                bindto: '#payments_by_month',
                data: {
                    rows: payments_by_month,
                    type: 'area-spline'
                },
                color: {
                    pattern: ['#4fc1e9','#a0d468']
                },
                axis: {
                    x: {
                        tick: {
                            format: function (d) {
                                return formatMonth(d);
                            }
                        }
                    }
                },
                legend: {
                    show: true,
                    position: 'bottom'
                },
                padding: {
                    top: 10
                }
            });

            function formatMonth(d) {

                @foreach($per_month as $id => $item)
                if ('{{$id}}' == d) {
                    return '{{$item['month']}}' + ' ' + '{{$item['year']}}'
                }
                @endforeach
            }

            setTimeout(function () {
                payments.resize();
            }, 2000);

            setTimeout(function () {
                payments.resize();
            }, 4000);

            setTimeout(function () {
                payments.resize();
            }, 6000);
            $("[data-toggle='offcanvas']").click(function (e) {
                payments.resize();
            });

        });

        $(function () {
            var students_section_per_year = [
                ['{{trans('dashboard.students')}}','{{trans('dashboard.section')}}'],
                    @foreach($per_school_year as $item)
                [{{$item['number_of_students']}},{{$item['number_of_sections']}}],
                @endforeach
            ];
            var students_section = c3.generate({
                bindto: '#students_section_per_year',
                data: {
                    rows: students_section_per_year,
                    type: 'area-spline'
                },
                color: {
                    pattern: ['#a0d468','#4fc1e9']
                },
                axis: {
                    x: {
                        tick: {
                            format: function (d) {
                                return formatSchoolYear(d);
                            }
                        }
                    }
                },
                legend: {
                    show: true,
                    position: 'bottom'
                },
                padding: {
                    top: 10
                }
            });

            function formatSchoolYear(d) {

                @foreach($per_school_year as $id => $item)
                if ('{{$id}}' == d) {
                    return '{{$item['school_year']}}'
                }
                @endforeach
            }

            setTimeout(function () {
                students_section.resize();
            }, 2000);

            setTimeout(function () {
                students_section.resize();
            }, 4000);

            setTimeout(function () {
                students_section.resize();
            }, 6000);
            $("[data-toggle='offcanvas']").click(function (e) {
                students_section.resize();
            });

        });

        var chart_students_gender = c3.generate({
            bindto: '#students_gender',
            data: {
                columns: [
                        @foreach($students_by_gender as $item)
                    ['{{$item['gender']}}', {{$item['count']}}],
                    @endforeach
                ],
                type: 'donut',
                colors: {
                    @foreach($students_by_gender as $item)
                    '{{$item['gender']}}': '{{$item['color']}}',
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


        var chart_teachers_gender = c3.generate({
            bindto: '#teachers_gender',
            data: {
                columns: [
                        @foreach($teachers_by_gender as $item)
                    ['{{$item['gender']}}', {{$item['count']}}],
                    @endforeach
                ],
                type: 'donut',
                colors: {
                    @foreach($teachers_by_gender as $item)
                    '{{$item['gender']}}': '{{$item['color']}}',
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

        $(function () {
            var send_sms_by_month = [
                ['{{trans('dashboard.send_sms')}}'],
                    @foreach($per_month as $item)
                [{{$item['sent_sms_by_month']}}],
                @endforeach
            ];
            var send_sms = c3.generate({
                bindto: '#send_sms',
                data: {
                    rows: send_sms_by_month,
                    type: 'area-spline'
                },
                color: {
                    pattern: ['#4fc1e9']
                },
                axis: {
                    x: {
                        tick: {
                            format: function (d) {
                                return formatMonth(d);
                            }
                        }
                    }
                },
                legend: {
                    show: true,
                    position: 'bottom'
                },
                padding: {
                    top: 10
                }
            });

            function formatMonth(d) {

                @foreach($per_month as $id => $item)
                if ('{{$id}}' == d) {
                    return '{{$item['month']}}' + ' ' + '{{$item['year']}}'
                }
                @endforeach
            }

            setTimeout(function () {
                send_sms.resize();
            }, 2000);

            setTimeout(function () {
                send_sms.resize();
            }, 4000);

            setTimeout(function () {
                send_sms.resize();
            }, 6000);
            $("[data-toggle='offcanvas']").click(function (e) {
                send_sms.resize();
            });

        });
    </script>
@stop
