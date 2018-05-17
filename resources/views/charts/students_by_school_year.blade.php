<div id="student_by_school_year"></div>
<script>
    $(function () {
        var student_by_school_year = [
            ['{{trans('dashboard.sum_students')}}'],
                @foreach($school_years as $item)
            [{{$item->students->count()}}],
            @endforeach
        ];
        c3.generate({
            bindto: '#student_by_school_year',
            data: {
                rows: student_by_school_year,
                type: 'area-spline'
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
            @foreach($school_years as $id => $item)
            if ('{{$id}}' == d) {
                return '{{$item->title}}'
            }
            @endforeach
        }

    });
</script>