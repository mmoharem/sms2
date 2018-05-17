@extends('layouts.secure')
@section('content')
    <div class="row">
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
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
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="animated flipInY">
                <div class="tile-stats">
                    <div class="count"><span id="apply_leave_total"></span></div>
                    <h3>{{trans('dashboard.apply_leave_total')}}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-xs-12">
            <h1>{{trans('dashboard.calendar')}}</h1>
            <div id="calendar"></div>
        </div>
        <div class="col-sm-6 col-xs-12">
            <h1>{{trans('dashboard.books')}}</h1>
            <div id="books"></div>
            <div id="book_categories"></div>
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
        var chart = c3.generate({
            bindto: '#books',
            data: {
                columns: [
                    @foreach($books as $item)
                        ['{{$item['title']}}', {{$item['items']}}],
                    @endforeach
                ],
                type: 'donut',
                colors: {
                    @foreach($books as $item)
                            '{{$item['title']}}': '{{$item['color']}}',
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

        var chart_book_categories = c3.generate({
            bindto: '#book_categories',
            data: {
                columns: [
                        @foreach($book_categories as $item)
                    ['{{$item['value']}}', {{$item['books']}}],
                    @endforeach
                ],
                type: 'donut',
                colors: {
                    @foreach($book_categories as $item)
                    '{{$item['value']}}': '{{$item['color']}}',
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
                        placement: 'auto'
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
    </script>
@stop
