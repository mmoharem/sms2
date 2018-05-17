@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    {{trans('mark.mark_title')}}
    <div class="row">
        <div class="col-sm-3">
            <select name="current_student_group" id="current_student_group" class="form-control select2">
                @foreach($student_groups as $student_group)
                    <option value="{{$student_group['id']}}">
                        {{ $student_group['title'].' - ' .$student_group['direction']  }}
                    </option>
                @endforeach
            </select>
            <ul class="list-group" id="students">
                <li class="list-group-item disabled">
                    {{trans('mark.students')}}
                </li>
                @foreach($students as $key =>$item)
                    <li id="{{$key}}" class="list-group-item">{{$item}}</li>
                @endforeach
            </ul>
        </div>
        <div class="col-sm-9">
            <div class="row">
                <div class="col-sm-4">
                    {!! Form::label('date', trans('mark.date'), array('class' => 'control-label')) !!}
                    <div class="controls" style="position: relative">
                        {!! Form::text('date', '', array('class' => 'form-control date')) !!}
                    </div>
                </div>
                <div class="col-sm-4">
                    {!! Form::label('subject_id', trans('mark.subject'), array('class' => 'control-label')) !!}
                    {!! Form::select('subject_id', $subjects, null, array('id'=>'subject_id',
                     'class' => 'form-control select2', 'placeholder'=>trans('mark.select_subject'))) !!}
                </div>
                <div class="col-sm-4">
                    {!! Form::label('mark_type_id', trans('mark.mark_type'), array('class' => 'control-label')) !!}
                    {!! Form::select('mark_type_id', $marktype, null, array('id'=>'mark_type_id', 'class' => 'form-control select2')) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-8">
                    {!! Form::label('comment', trans('mark.comment'), array('class' => 'control-label')) !!}
                    {!! Form::textarea('comment', null, array('id'=>'comment', 'class' => 'form-control','size' => '30x5')) !!}
                </div>
                <div class="col-sm-4">
                    {!! Form::label('mark_value_id', trans('mark.mark_value'), array('class' => 'control-label')) !!}
                    {!! Form::select('mark_value_id', array(), null, array('id'=>'mark_value_id', 'class' => 'form-control select2')) !!}
                    {!! Form::label('mark_percent', trans('mark.mark_percent'), array('class' => 'control-label')) !!}
                    {!! Form::text('mark_percent', '', array('class' => 'form-control')) !!}
                    {!! Form::label('exam_id', trans('mark.exam'), array('class' => 'control-label')) !!}
                    {!! Form::select('exam_id', array(), null, array('id'=>'exam_id', 'class' => 'form-control select2')) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <br>
                    <button type="button" class="btn btn-success btn-sm add_mark">{{trans('mark.add_mark')}}</button>
                </div>
            </div>
            <br>

            <div id="marks">
                <table class="table table-bordered">
                    <thead>
                    <th class="col-sm-4">{{trans('mark.student')}}</th>
                    <th class="col-sm-3">{{trans('mark.mark_type')}}</th>
                    <th class="col-sm-2">{{trans('mark.mark_value')}}</th>
                    <th class="col-sm-2">{{trans('mark.overall_grade')}}</th>
                    <th class="col-sm-2">{{trans('mark.delete')}}</th>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        function changeSubject(){
            $('#subject_id').change(function () {
                var subject_id = $(this).val();
                var date = $('#date').val();
                $('#exam_id').html('');
                $('#mark_value_id').html('');
                if (subject_id > 0) {
                    $('#exam_id').append($('<option></option>').val(0).html('{{trans('mark.no_selected_exam')}}'));
                    $.ajax({
                        type: "POST",
                        url: '{{ url('/mark/exams') }}',
                        data: {_token: '{{ csrf_token() }}', subject_id: subject_id},
                        success: function (result) {
                            $.each(result, function (val, text) {
                                $('#exam_id').append($('<option></option>').val(val).html(text))
                            });
                        }
                    });
                    if (subject_id != "" && date != "") {
                        getmarks(subject_id, date)
                    }
                    $.ajax({
                        type: "POST",
                        url: '{{ url('/mark/mark_values') }}',
                        data: {_token: '{{ csrf_token() }}', subject_id: subject_id},
                        success: function (result) {
                            $.each(result, function (val, text) {
                                $('#mark_value_id').append($('<option></option>').val(val).html(text))
                            });
                        }
                    });
                }
            });
        }

        $('#current_student_group').change(function(){
            $('#subject_id').empty().select2("val", "");
            $('#students').empty();
            $('#subject_id').val("").trigger('change');
            $('#date').val("");
            $.ajax({
                type: "POST",
                url: '{{ url('/mark') }}/'+$(this).val(),
                data: {_token: '{{ csrf_token() }}'},
                success: function (result) {
                    $('#students').append('<li class="list-group-item disabled">{{trans('attendance.students')}}</li>');
                    $.each(result.students, function (val, text) {
                        $('#students').append('<li class="list-group-item" id="'+val+'">'+text+'</li>');
                    });
                    $('.list-group-item').not(".disabled").click(function () {
                        $(this).toggleClass('active');
                    });
                    $.each(result.subjects, function (val, text) {
                        $('#subject_id').append($('<option></option>').val(val).html(text))
                    });
                    changeSubject();
                }
            });
        });
        $('.list-group-item').not(".disabled").click(function () {
            $(this).toggleClass('active');
        });
        changeSubject();
        $('#date').change(function () {
            var date = $(this).val();
            var subject_id = $('#subject_id').val();
            if (subject_id != "" && date != "") {
                getmarks(subject_id, date)
            }
        });

        function getmarks(subject_id, date) {
            $('#marks tbody').empty();
            $.ajax({
                type: "POST",
                url: '{{ url('/mark/marks') }}',
                data: {_token: '{{ csrf_token() }}', subject_id: subject_id, date: date},
                success: function (result) {
                    data = $.parseJSON(result);
                    $.each(data, function (i, item) {
                        $('#marks tbody').append('<tr><td>' + item.name + '</td><td>' + item.mark_type + '</td><td>' + item.mark_value + '</td><td>' + item.mark_percent + '</td><td class="btn btn-danger btn-sm delete_mark" id="' + item.id + '"><i class="fa fa-trash-o"></i></td></tr>');
                    });
                    able_delete_mark();
                }
            })
        }

        $('.add_mark').click(function () {
            var subject_id = $('#subject_id').val();
            var date = $('#date').val();
            var mark_type_id = $('#mark_type_id').val();
            var comment = $('#comment').val();
            var mark_value_id = $('#mark_value_id').val();
            var exam_id = $('#exam_id').val();
            var mark_percent = $('#mark_percent').val();
            var students = $.makeArray($('.list-group-item.active').map(function (index) {
                return this.id;
            }));
            if (subject_id.length > 0 && students.length > 0 && date.length > 0 && mark_value_id.length > 0 && mark_type_id.length > 0) {
                $.ajax({
                    type: "POST",
                    url: '{{ url('/mark/add') }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        subject_id: subject_id,
                        date: date,
                        mark_type_id: mark_type_id,
                        comment: comment,
                        mark_value_id: mark_value_id,
                        exam_id: exam_id,
                        mark_percent: mark_percent,
                        students: students
                    },
                    success: function () {
                        $('.list-group-item').removeClass('active');
                        getmarks(subject_id, date);
                    }
                })
            }
        });
        function able_delete_mark() {
            $('.delete_mark').click(function () {
                var $mark = $(this);
                var mark_id = $mark.attr('id');
                $.ajax({
                    type: "POST",
                    url: '{{ url('/mark/delete') }}',
                    data: {_token: '{{ csrf_token() }}', id: mark_id},
                    success: function (result) {
                        $mark.parent().remove();
                    }
                })
            })
        }
    </script>
@endsection

