<div id="section_students"></div>
<script type="text/javascript">
    c3.generate({
        bindto: '#sections',
        data: {
            columns: [
                    @foreach($sectionsChart as $section)
                ['{{$section->title}}', {{$section->students->count()}}],
                @endforeach
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
