@extends('layouts.secure')
@section('content')
    <h1>{{trans('dashboard.calendar')}}</h1>
    <div id="calendar"></div>

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
    <script>
    $(document).ready(function() {
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
                    url:"{{url('events')}}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    error: function() {
                        alert('there was an error while fetching events!');
                    }
                }
            ]
        });
    });
    </script>
    @stop
