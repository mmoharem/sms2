<div id="student_genders"></div>
<script type="text/javascript">
    c3.generate({
        bindto: '#student_genders',
        data: {
            columns: [
                ['{{trans('student.male')}}', {{$maleStudents}}],
                ['{{trans('student.female')}}', {{$femaleStudents}}]
            ],
            type: 'pie',
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
</script>