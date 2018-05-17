<div class="row">
    <div class="panel-heading">
        <h4>{{trans('student.filters')}}</h4>
    </div>
    {!! Form::open() !!}
    <div class="row">
        <div class="col-sm-6 col-lg-3">
            {!! Form::label('first_name', trans('student.first_name'), array('class' => 'control-label')) !!}
            {!! Form::text('first_name', old('first_name'), array('class' => 'form-control')) !!}
        </div>
        <div class="col-sm-6 col-lg-3">
            {!! Form::label('last_name', trans('student.last_name'), array('class' => 'control-label')) !!}
            {!! Form::text('last_name', old('last_name'), array('class' => 'form-control')) !!}
        </div>
        <div class="col-sm-6 col-lg-3">
            {!! Form::label('student_no', trans('visitor_student_card.student_no'), array('class' => 'control-label')) !!}
            {!! Form::text('student_no', old('student_no'), array('class' => 'form-control')) !!}
        </div>
        <div class="col-sm-6 col-lg-3">
            {!! Form::label('country_id', trans('student.country_id'), array('class' => 'control-label')) !!}
            {!! Form::select('country_id', $countries, old('country_id'), ['id'=>'country_id', 'class' =>
            'form-control select2', 'placeholder'=>trans('student.select_country')]) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-lg-3">
            {!! Form::label('session_id', trans('student.session_id'), array('class' => 'control-label')) !!}
            {!! Form::select('session_id', $sessions, old('session_id'), ['id'=>'session_id', 'class' =>
            'form-control select2','placeholder'=>trans('student.select_session')]) !!}
        </div>
        <div class="col-sm-6 col-lg-3">
            {!! Form::label('section_id', trans('student.section_id'), array('class' => 'control-label')) !!}
            {!! Form::select('section_id', $sections, old('section_id'), ['id'=>'section_id',
            'class' => 'form-control select2','placeholder'=>trans('student.select_section')]) !!}
        </div>
        <div class="col-sm-6 col-lg-3">
            {!! Form::label('level_id', trans('student.level'), array('class' => 'control-label')) !!}
            {!! Form::select('level_id', $levels, old('level_id'), ['id'=>'level_id',
            'class' => 'form-control select2','placeholder'=>trans('student.select_level')]) !!}
        </div>
        <div class="col-sm-6 col-lg-3">
            {!! Form::label('entry_mode_id', trans('student.entry_mode'), array('class' => 'control-label')) !!}
            {!! Form::select('entry_mode_id', $entrymodes, old('entry_mode_id'), ['id'=>'entry_mode_id',
            'class' => 'form-control select2', 'placeholder'=>trans('student.select_entry_mode')]) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-lg-3">
            {!! Form::label('gender', trans('student.gender'), array('class' => 'control-label')) !!}
            {!! Form::select('gender', [0=>trans('student.female'), 1=>trans('student.male')], old('gender'),
            ['id'=>'gender', 'class' => 'form-control select2', 'placeholder'=>trans('student.select_gender')]) !!}
        </div>
        <div class="col-sm-6 col-lg-3">
            {!! Form::label('marital_status_id', trans('student.marital'), array('class' => 'control-label')) !!}
            {!! Form::select('marital_status_id', $maritalStatus, old('marital_status_id'), ['id'=>'marital_status_id',
            'class' => 'form-control select2','placeholder'=>trans('student.select_marital_status')]) !!}
        </div>
        <div class="col-sm-6 col-lg-3">
            {!! Form::label('dormitory_id', trans('student.dormitory'), array('class' => 'control-label')) !!}
            {!! Form::select('dormitory_id', $dormitories, old('dormitory_id'), ['id'=>'dormitory_id',
            'class' => 'form-control select2','placeholder'=>trans('student.select_dormitory')]) !!}
        </div>
        <div class="col-sm-6 col-lg-3">
        </div>
    </div>
    <br>
    <button type="submit" class="btn btn-success btn-sm filter">{{trans('student.filter')}}</button>
    {{Form::close()}}
</div>
<script>
    $('#session_id').change(function () {
        $('#level_id').empty();
        $('#section_id').empty();
        $.ajax({
            type: "GET",
            url: '{{url('/student')}}/' + $(this).val() + '/sections',
            success: function (response) {
                $('#level_id').append($('<option></option>').val(null).html('{{trans('student.select_level')}}'));
                $('#section_id').append($('<option></option>').val(null).html('{{trans('student.select_section')}}'));
                $.each(response.sections, function (val, text) {
                    $('#section_id').append($('<option></option>').val(text.id).html(text.title));
                });
            }
        });
    });
    $('#section_id').change(function () {
        $('#level_id').empty();
        $.ajax({
            type: "GET",
            url: '{{url('/student')}}/' + $(this).val() + '/levels',
            success: function (response) {
                $('#level_id').append($('<option></option>').val(null).html('{{trans('student.select_level')}}'));
                $.each(response.levels, function (val, text) {
                    $('#level_id').append($('<option></option>').val(text.id).html(text.name));
                });
            }
        });
    });
</script>