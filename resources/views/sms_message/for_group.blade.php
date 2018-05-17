@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    <div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        {!! Form::open(array('url' => url($type.'/store_group'), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
        <div class="form-group {{ $errors->has('text') ? 'has-error' : '' }}">
            {!! Form::label('text', trans('sms_message.text'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::textarea('text', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('text', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('groups') ? 'has-error' : '' }}">
            {!! Form::label('groups', trans('sms_message.receivers'), array('class' => 'control-label required')) !!}
            <div class="controls">
                <div class="controls">
                    {!! Form::select('groups[]', $groups, null, array('id'=>'groups', 'multiple'=>true, 'class' => 'form-control select2')) !!}
                </div>
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
