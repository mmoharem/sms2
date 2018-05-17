<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        @if (isset($registration))
            {!! Form::model($registration, array('url' => url($type) . '/' . $registration->id, 'method' => 'put', 'class' => 'bf', 'files'=> true)) !!}
        @else
            {!! Form::open(array('url' => url($type), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
        @endif
        @if (!isset($registration))
            <div class="form-group {{ $errors->has('section_id') ? 'has-error' : '' }}">
                {!! Form::label('section_id', trans('student.section_id'), array('class' => 'control-label required')) !!}
                <div class="controls">
                    {!! Form::select('section_id',  $sections,  null, array('id'=>'section_id', 'class' => 'form-control select2')) !!}
                    <span class="help-block">{{ $errors->first('section_id', ':message') }}</span>
                </div>
            </div>
            <div class="form-group {{ $errors->has('student_group_id') ? 'has-error' : '' }}">
                {!! Form::label('student_group_id', trans('student.student_group'), array('class' => 'control-label required')) !!}
                <div class="controls">
                    {!! Form::select('student_group_id', [], null, array('id'=>'student_group_id', 'class' => 'form-control select2')) !!}
                    <span class="help-block">{{ $errors->first('student_group_id', ':message') }}</span>
                </div>
            </div>
            <div class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
                {!! Form::label('user_id', trans('invoice.students'), array('class' => 'control-label required')) !!}
                <div class="controls">
                    {!! Form::select('user_id[]', [], null, array('id'=>'user_id', 'multiple'=>true, 'class' => 'form-control select2')) !!}
                    <span class="help-block">{{ $errors->first('user_id', ':message') }}</span>
                </div>
            </div>
        @else
            <div class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
                {!! Form::label('user_id', trans('invoice.student'), array('class' => 'control-label required')) !!}
                <div class="controls">
                    {!! Form::select('user_id', $students, null, array('id'=>'user_id', 'class' => 'form-control select2')) !!}
                    <span class="help-block">{{ $errors->first('user_id', ':message') }}</span>
                </div>
            </div>
        @endif
        <div class="form-group {{ $errors->has('level_id') ? 'has-error' : '' }}">
            {!! Form::label('level_id', trans('student.level'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('level_id', $levels, null, array('id'=>'level_id', 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('level_id', ':message') }}</span>
            </div>
        </div>
        @if (isset($registration))
            <div class="form-group {{ $errors->has('subject_id') ? 'has-error' : '' }}">
                {!! Form::label('subject_id', trans('registration.subject_id'), array('class' => 'control-label required')) !!}
                <div class="controls">
                    {!! Form::select('subject_id', $subjects, null, array('id'=>'subject_id', 'class' => 'form-control select2')) !!}
                    <span class="help-block">{{ $errors->first('subject_id', ':message') }}</span>
                </div>
            </div>
        @else
            <div class="form-group {{ $errors->has('subject_id') ? 'has-error' : '' }}">
                {!! Form::label('subject_id', trans('registration.subject_id'), array('class' => 'control-label required')) !!}
                <div class="controls">
                    {!! Form::select('subject_id[]', [], null, array('id'=>'subject_id', 'multiple'=>true, 'class' => 'form-control select2')) !!}
                    <span class="help-block">{{ $errors->first('subject_id', ':message') }}</span>
                </div>
            </div>
        @endif
        <div class="form-group {{ $errors->has('remarks') ? 'has-error' : '' }}">
            {!! Form::label('remarks', trans('registration.remarks'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::textarea('remarks', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('remarks', ':message') }}</span>
            </div>
        </div>
        <div class="form-group">
            <div class="controls">
                <a href="{{ url($type) }}" class="btn btn-primary btn-sm">{{trans('table.cancel')}}</a>
                <button type="submit" class="btn btn-success btn-sm">{{trans('table.ok')}}</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@section('scripts')
    <script>
        $('#section_id').change(function () {
            $('#level_id').empty();
            $('#student_group_id').empty();
            $.ajax({
                type: "GET",
                url: '{{url('/student')}}/' + $(this).val() + '/levels',
                success: function (response) {
                    $('#level_id').append($('<option></option>').val(null).html('{{trans('student.select_level')}}'));
                    $('#student_group_id').append($('<option></option>').val(null).html('{{trans('student.select_group')}}'));
                    $.each(response.levels, function (val, text) {
                        $('#level_id').append($('<option></option>').val(text.id).html(text.name));
                    });
                    $.each(response.student_groups, function (val, text) {
                        $('#student_group_id').append($('<option></option>').val(text.id).html(text.title));
                    });
                }
            });
        });
        $('#student_group_id').change(function () {
            $('#subject_id').empty();
            $('#user_id').empty();
            $.ajax({
                type: "GET",
                url: '{{url('/registration')}}/' + $(this).val() + '/subjects_students',
                success: function (response) {
                    $('#subject_id').append($('<option></option>').val(null).html('{{trans('registration.select_subject')}}'));
                    $('#user_id').append($('<option></option>').val(null).html('{{trans('student.select_student')}}'));
                    $.each(response.subjects, function (val, text) {
                        $('#subject_id').append($('<option></option>').val(text.id).html(text.name));
                    });
                    $.each(response.students, function (val, text) {
                        $('#user_id').append($('<option></option>').val(text.user_id).html(text.user.full_name));
                    });
                }
            });
        });
    </script>
@endsection
