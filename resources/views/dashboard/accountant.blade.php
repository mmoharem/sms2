@extends('layouts.secure')
@section('content')
    <div class="row">
        <div class="col-sm-6 col-xs-12">
            <h1>{{trans('dashboard.salary_by_month')}}</h1>
            <div id="salary_by_month"></div>
        </div>
        <div class="col-sm-6 col-xs-12">
            <h1>{{trans('dashboard.payments_by_month')}}</h1>
            <div id="payments_by_month"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-xs-12">
            <h1>{{trans('dashboard.expense_by_month')}}</h1>
            <div id="expense_by_month"></div>
        </div>
        <div class="col-sm-6 col-xs-12">
            <h1>{{trans('dashboard.students_section_per_year')}}</h1>
            <div id="students_section_per_year"></div>
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
    <script>
        $(function () {
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
            var expense_by_month = [
                ['{{trans('dashboard.expense_by_month')}}'],
                    @foreach($per_month as $item)
                [{{$item['sum_of_expense']}}],
                @endforeach
            ];
            var expense = c3.generate({
                bindto: '#expense_by_month',
                data: {
                    rows: expense_by_month,
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
                expense.resize();
            }, 2000);

            setTimeout(function () {
                expense.resize();
            }, 4000);

            setTimeout(function () {
                expense.resize();
            }, 6000);
            $("[data-toggle='offcanvas']").click(function (e) {
                expense.resize();
            });

        });

        $(function () {
            var payments_by_month = [
                ['{{trans('dashboard.sum_of_payments')}}', '{{trans('dashboard.sum_of_invoices')}}'],
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
                    pattern: ['#4fc1e9', '#a0d468']
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
                ['{{trans('dashboard.students')}}', '{{trans('dashboard.section')}}', '{{trans('dashboard.sum_of_expense')}}'],
                    @foreach($per_school_year as $item)
                [{{$item['number_of_students']}},{{$item['number_of_sections']}},{{$item['sum_of_expense']}}],
                @endforeach
            ];
            var students_section = c3.generate({
                bindto: '#students_section_per_year',
                data: {
                    rows: students_section_per_year,
                    type: 'area-spline'
                },
                color: {
                    pattern: ['#a0d468', '#4fc1e9', '#635424']
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
    </script>
@stop
