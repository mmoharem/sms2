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
                    <i class="fa fa-server fa-1x"></i>
                </div>
                <div class="count"><span id="schools"></span></div>
                <h3>{{trans('dashboard.schools')}}</h3>
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

    <div class="row">
        <div class="col-sm-6 col-xs-12">
            <h1>{{trans('dashboard.schools')}}</h1>
            <ul class="list-group">
                @foreach($schools_list as $school)
                    <a href="{{url('schools/'.$school->id.'/show')}}" class="list-group-item list-group-item-success">
                        {{$school->title}}
                    </a>
                @endforeach
            </ul>
        </div>
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
        <div class="col-sm-6 col-xs-12">
            @if(Settings::get('sms_driver')!=""  && Settings::get('sms_driver') !='none')
                <h1>{{trans('dashboard.sms_messages_by_school')}}</h1>
                <table class="table table-responsive">
                    <thead>
                    <tr>
                        <td>{{trans('schools.school')}}</td>
                        <td>{{trans('schools.limit_sms_messages')}}</td>
                        <td>{{trans('dashboard.send_sms')}}</td>
                    </tr>
                    </thead>
                    @foreach($schools_list as $school)
                        <tr>
                            <td>{{$school->title}}</td>
                            <td>{{$school->limit_sms_messages}}</td>
                            <td>{{$school->sms_messages_year}}</td>
                        </tr>
                    @endforeach
                </table>
            @endif
        </div>

    </div>
    @if(Settings::get('sms_driver')!=""  && Settings::get('sms_driver') !='none')
        <div class="row">
            <h1>{{trans('dashboard.sms_messages_by_month')}}</h1>
            @foreach(array_chunk($schools_list->all(), 3) as $row)
                <div class="row">
                    @foreach($row as $school)
                        <div class="col-sm-4">
                            {{$school->title}}
                            <div id="send_sms_{{$school->id}}"></div>
                            <script>
                                $(function () {
                                    var send_sms_by_month = [
                                        ['{{trans('dashboard.send_sms')}}'],
                                            @foreach($per_month[$school->id] as $item)
                                        [{{$item['sent_sms_by_month']}}],
                                        @endforeach
                                    ];
                                    var send_sms = c3.generate({
                                        bindto: '#send_sms_{{$school->id}}',
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

                                        @foreach($per_month[$school->id] as $id => $item)
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
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    @endif
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
            var schools = new CountUp("schools", 0, "{{$schools_list->count()}}", 0, 3, options);
            schools.start();
            var teachers = new CountUp("teachers", 0, "{{$teachers}}", 0, 3, options);
            teachers.start();
            var parents = new CountUp("parents", 0, "{{$parents}}", 0, 3, options);
            parents.start();
            var directions = new CountUp("directions", 0, "{{$directions}}", 0, 3, options);
            directions.start();
        });
    </script>
@stop
