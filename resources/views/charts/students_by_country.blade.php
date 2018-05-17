<div id="student_by_country"></div>
<script>
    $(function () {
        var student_by_country = [
            ['{{trans('dashboard.sum_students')}}'],
                @foreach($countries as $item)
            [{{$item->students->count()}}],
            @endforeach
        ];
        c3.generate({
            bindto: '#student_by_country',
            data: {
                rows: student_by_country,
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
            @foreach($countries as $id => $item)
            if ('{{$id}}' == d) {
                return '{{$item->name}}'
            }
            @endforeach
        }
    });
</script>