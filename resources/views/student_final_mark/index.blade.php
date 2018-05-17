@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop
{{-- Content --}}
@section('content')
    {!! Form::open(array('url' => url($type), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
    <div class="form-group required {{ $errors->has('section_select') ? 'has-error' : '' }}">
        {!! Form::label('section_select',trans('student_final_mark.select_section'), array('class' => 'control-label')) !!}
        <div class="controls">
            {!! Form::select('section_select', $sections, null, array('id'=>'section_select', 'class' => 'form-control select2')) !!}
            <span class="help-block">{{ $errors->first('section_select', ':message') }}</span>
        </div>
    </div>
    <div class="form-group required {{ $errors->has('group_select') ? 'has-error' : '' }}">
        {!! Form::label('group_select',trans('student_final_mark.group_select'), array('class' => 'control-label')) !!}
        <div class="controls">
            {!! Form::select('group_select', array(), null, array('id'=>'group_select', 'class' => 'form-control select2')) !!}
            <span class="help-block">{{ $errors->first('group_select', ':message') }}</span>
        </div>
    </div>
    <div class="form-group required {{ $errors->has('group_select') ? 'has-error' : '' }}">
        {!! Form::label('subject_select',trans('student_final_mark.subject_select'), array('class' => 'control-label')) !!}
        <div class="controls">
            {!! Form::select('subject_select', array(), null, array('id'=>'subject_select', 'class' => 'form-control select2')) !!}
            <span class="help-block">{{ $errors->first('subject_select', ':message') }}</span>
        </div>
    </div>
    {!! Form::label('change_save',trans('student_final_mark.change_save'), array('class' => 'control-label')) !!}
    <div id="students">

    </div>
    {!! Form::close() !!}
@stop

@section('scripts')
    <script>
        $( document ).ready(function() {
            $("#section_select").change(function() {
                $('#students').empty();

                var $select = $('#subject_select');
                $select.find('option').remove();

                var $select = $('#group_select');
                $select.find('option').remove();

                if ($(this).val() != "") {
                    $.ajax({
                        type: "GET",
                        url: '{{url('/student_final_mark/')}}/' + $(this).val() + '/get-groups',
                        success: function (response) {
                            $select.append('<option value="">{{trans('student_final_mark.group_select')}}</option>');
                            $.each(response, function (key, val) {
                                $select.append('<option value=' + key + '>' + val + '</option>');
                            })
                        }
                    });
                }
            });
        });

        $("#group_select").change(function() {

            $('#students').empty();

            var $select = $('#subject_select');
            $select.find('option').remove();

            if ($(this).val() != "") {
                $.ajax({
                    type: "GET",
                    url: '{{url('/student_final_mark/')}}/' + $(this).val() + '/get-subjects',
                    success: function (response) {
                        $select.append('<option value="">{{trans('student_final_mark.subject_select')}}</option>');
                        $.each(response, function (key, val) {
                            $select.append('<option value=' + key + '>' + val + '</option>');
                        })

                    }
                });
            }
        });
        $("#subject_select").change(function() {

            $('#students').empty();

            if ($(this).val() != "") {
                var mark_values_student = '<br><div class="row"><div class="col-sm-3"><b>{{trans('student_final_mark.student')}}</b></div>' +
                                            '<div class="col-sm-3"><b>{{trans('student_final_mark.marks')}}</b></div>'+
                                            '<div class="col-sm-3"><b>{{trans('student_final_mark.final_mark')}}</b></div>'+
                                            '<div class="col-sm-3"><b>{{trans('student_final_mark.final_mark_percentage')}}</b></div>'+
                                            '</div>';
                $.ajax({
                    type: "GET",
                    url: '{{url('/student_final_mark/')}}/' + $("#group_select").val() + '/' + $(this).val() + '/get-students',
                    success: function (response) {
                        $.each(response.student_final_marks, function (key, val) {
                            mark_values_student += '<div class="row"><div class="col-sm-3"><label class="control-label">' + val.student_name + '</label></div>' +
                                    '<div class="col-sm-3">';
                            $.each(response.student_marks, function (key3, val3) {
                                if (val.student_id == key3) {
                                    $.each(val3, function (key4, mark) {
                                        mark_values_student += mark.date+ ' '+ mark.mark_value +
                                            ((mark.mark_percent!="")? " ("+mark.mark_percent+"%)":"") +
                                            ' - '+ mark.mark_type+'<br>';
                                    })
                                }
                            });
                            mark_values_student += '</div><div class="col-sm-3"><select name="mark_value[' + val
                                .student_id + ']" class="form-control" id="mark_value_'+val.student_id+'">';
                            $.each(response.mark_values, function (key2, val2) {
                                mark_values_student += '<option ';
                                if (val.mark_value == key2) {
                                    mark_values_student += ' selected="selected"';
                                }
                                mark_values_student += 'value="'+key2+'">'+val2+'</option>';
                            });
                            let student_id = val.student_id;
                            mark_values_student +='</select></div><div class="col-sm-3">' +
                                '<input type="text" class="form-control" id="mark_value_percent_'+student_id+'" ' +
                                'value="'+ response.student_final_marks[student_id].mark_value_percent+'">'+
                                '<button type="button" class="btn btn-success btn-xs" ' +
                                'id="btn_add_mark_'+student_id+'">{{trans('mark.add_mark')}}</button></div></div><br>';
                        });
                        $('#students').html(mark_values_student);

                        $('[id^="btn_add_mark_"]').click(function() {
                            let select_name = $(this).attr("id");
                            let student = select_name.split('btn_add_mark_')[1];

                            let mark_value = $('#mark_value_'+student).val();
                            let mark_percent = $('#mark_value_percent_'+student).val();
                            let subject = $("#subject_select").val();

                            $.ajax({
                                type: "POST",
                                url: '{{url('/student_final_mark/add-final-mark')}}',
                                data: {_token: '{{ csrf_token() }}',
                                    mark_percent: mark_percent,
                                    mark_value_id: mark_value,
                                    student_id: student,
                                    subject_id: subject},
                                success: function () {

                                }
                            });
                        })
                    }
                });
            }
        });
    </script>
@endsection