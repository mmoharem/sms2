@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop
@section('content')
    <div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
       {!! Form::open(array('url' => url('admin_exam/store_by_group'), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
        <div class="form-group {{ $errors->has('group_id') ? 'has-error' : '' }}">
            {!! Form::label('group_id', trans('admin_exam.groups'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('group_id[]', $groups, null, array('id'=>'group_id', 'class' => 'form-control select2', 'multiple')) !!}
                <span class="help-block">{{ $errors->first('group_id', ':message') }}</span>
            </div>
        </div>
            <div class="form-group {{ $errors->has('option_id') ? 'has-error' : '' }}">
                {!! Form::label('option_id', trans('exam.exam_type'), array('class' => 'control-label required')) !!}
                <div class="controls">
                    {!! Form::select('option_id', $exam_types, null, array('id'=>'option_id', 'class' => 'form-control select2')) !!}
                    <span class="help-block">{{ $errors->first('option_id', ':message') }}</span>
                </div>
            </div>
        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
            {!! Form::label('title', trans('exam.title'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('title', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('title', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
            {!! Form::label('description', trans('exam.description'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::textarea('description', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('description', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('date') ? 'has-error' : '' }}">
            {!! Form::label('date', trans('exam.date'), array('class' => 'control-label required')) !!}
            <div class="controls" style="position: relative">
                {!! Form::text('date', null, array('class' => 'form-control date')) !!}
                <span class="help-block">{{ $errors->first('date', ':message') }}</span>
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
@stop

@section('scripts')
    <script>
    </script>
@endsection
