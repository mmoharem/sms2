@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    {{trans('studentgroup.students_info')}}
    {!! Form::label('students', $studentGroup->title, array('class' => 'control-label')) !!}
    {!! Form::model($studentGroup, array('url' => url($type) . '/' . $section->id. '/' . $studentGroup->id.'/addstudents', 'method' => 'put', 'class' => 'bf', 'files'=> true)) !!}
    <div class="form-group">
        <div class="controls">
            {!! Form::select('students_select[]', $students, null, array('id'=>'students_select', 'multiple'=>true, 'class' => 'form-control select2')) !!}
            <input type="checkbox" id="select_all_students" >{{trans('studentgroup.select_all_students')}}
        </div>
    </div>
    <div class="form-group">
        <div class="controls">
            <a href="{{ url('/section/'.$section->id.'/groups') }}"
               class="btn btn-warning btn-sm">{{trans('table.back')}}</a>
            <button type="submit" class="btn btn-success btn-sm">{{trans('table.ok')}}</button>
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('scripts')
    <script>
        $("#select_all_students").click(function(){
            if($("#select_all_students").is(':checked') ){
                $("#students_select > option").prop("selected","selected");
                $("#students_select").trigger("change");
            }else{
                $("#students_select > option").removeAttr("selected");
                $("#students_select").trigger("change");
            }
        });
    </script>
@endsection

