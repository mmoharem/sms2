<table class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
    <tbody>
    <tr>
        <td><strong>{{trans('registration.section')}}</strong></td>
        <td><strong>{{trans('registration.registration')}}</strong></td>
        <td><strong>{{trans('registration.total_in_section')}}</strong></td>
    </tr>
    @foreach($sections as $section)
        <tr>
            <td>{{@$section->title}}</td>
            <td>
                 @if (isset($section->registrations)){{$section->registrations->count()}}@endif
            </td>
            <td>
                @if (isset($section->students)){{$section->students->count()}} @else {{'0'}} @endif
            </td>
        </tr>
    @endforeach
    <tr>
        <td><strong>{{trans('registration.total')}}</strong><strong></strong></td>
        <td><strong>{{$registrations->count()}}</strong></td>
        <td><strong>{{$students->count()}}</strong></td>
    </tr>
    </tbody>
</table>
  




