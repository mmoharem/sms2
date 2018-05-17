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
            <h4><label class="label label-info">{{trans('schoolyear.alumini_note').$schoolYear->title}}</label></h4>
            {!! Form::open(array('url' => url($type.'/'.$schoolYear->id.'/post_alumini'), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
             <div class="form-group {{ $errors->has('school_ids') ? 'has-error' : '' }}">
                {!! Form::label('school_ids', trans('schoolyear.select_school'), array('class' => 'control-label required')) !!}
                <div class="controls">
                    {!! Form::select('school_ids', $school_list, null, array('data-placeholder'=>trans('schoolyear.select_school'), 'id'=>'school_ids', 'multiple', 'class' => 'form-control select2')) !!}
                    <span class="help-block">{{ $errors->first('school_ids', ':message') }}</span>
                </div>
            </div>
            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                {!! Form::label('title', trans('schoolyear.alumini_title'), array('class' => 'control-label')) !!}
                <div class="controls">
                    {!! Form::text('title', null, array('id'=>'title', 'class' => 'form-control')) !!}
                    <span class="help-block">{{ $errors->first('title', ':message') }}</span>
                </div>
            </div>
            <br>
            <div class="form-group">
                <div class="controls">
                    <button type="submit" class="btn btn-success btn-sm">{{trans('table.ok')}}</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
	</div>
</div>
@stop

@section('scripts')
@endsection