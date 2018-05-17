@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                {!! Form::hidden('school_year_id', $schoolYear->id, array('id' => 'school_year_id')) !!}
                <div class="form-group {{ $errors->has('school_ids') ? 'has-error' : '' }}">
                    {!! Form::label('school_ids', trans('schoolyear.select_school'), array('class' => 'control-label required')) !!}
                    <div class="controls">
                        {!! Form::select('school_ids', $school_list, null, array('data-placeholder'=>trans('schoolyear.select_school'), 'id'=>'school_ids', 'multiple', 'class' => 'form-control select2')) !!}
                        <span class="help-block">{{ $errors->first('school_ids', ':message') }}</span>
                    </div>
                </div>
                <div class="form-group {{ $errors->has('alumini_id') ? 'has-error' : '' }}">
                    {!! Form::label('alumini_id', trans('schoolyear.select_alumini'), array('class' => 'control-label required')) !!}
                    <div class="controls">
                        {!! Form::select('alumini_id', $aluminis, null, array('data-placeholder'=>trans('schoolyear.select_alumini'), 'id'=>'alumini_id', 'class' => 'form-control select2')) !!}
                        <span class="help-block">{{ $errors->first('alumini_id', ':message') }}</span>
                    </div>
                </div>
                <br>
                <div class="form-group">
                    <div class="controls">
                        <button type="submit" class="btn btn-success btn-sm">{{trans('table.ok')}}</button>
                    </div>
                </div>
                <table id="results" class="table">
                    <thead>
                    <th>{{trans('student.full_name')}}</th>
                    <th>{{trans('school_admin.school')}}</th>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@stop
@section('scripts')
    <script>
        $(document).ready(function () {
            $(".btn-success").click(function () {
                $('#results>tbody').html('');
                var select_school_ids = $('#school_ids').val();
                var select_alumini_id = $('#alumini_id').val();
                var select_school_year_id = $('#school_year_id').val();
                if (select_alumini_id != "" && select_school_year_id != "") {
                    $.ajax({
                        type: "POST",
                        url: '{{url('/schoolyear')}}/' + select_school_year_id + '/' + select_alumini_id + '/get_alumini_students',
                        data: {_token: '{!! csrf_token() !!}', school_ids: select_school_ids},
                        success: function (response) {
                            $.each(response, function (val, text) {
                                $('#results>tbody').append('<tr><td>'+text.first_name+' '+text.last_name+'</td><td>'+text.title+'</td></tr>');
                            });
                        }
                    });
                }
            });
        })
    </script>
@endsection