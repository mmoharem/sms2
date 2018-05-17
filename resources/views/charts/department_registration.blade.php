<div id="section_registrations"></div>
<script type="text/javascript">
    c3.generate({
        bindto: '#sections',
        data: {
            columns: [
                    @foreach($sections as $section)
                [
                    "{{$section->title}}", @if (isset($section->registrations)){{$section->registrations->count()}}@else {{'0'}} @endif
                ],
                @endforeach
            ],
            type: 'spline'
        }
    });
</script>
