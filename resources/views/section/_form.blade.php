<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        @if (isset($section))
            {!! Form::model($section, array('url' => url($type) . '/' . $section->id, 'method' => 'put', 'class' => 'bf', 'files'=> true)) !!}
        @else
            {!! Form::open(array('url' => url($type), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
        @endif
        {!! Form::hidden('school_year_id', null, array('class' => 'form-control')) !!}
        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
            {!! Form::label('title', trans('section.title'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('title', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('title', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('id_code') ? 'has-error' : '' }}">
            {!! Form::label('id_code', trans('section.id_code'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('id_code', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('id_code', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('quantity') ? 'has-error' : '' }}">
            {!! Form::label('quantity', trans('section.quantity'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::input('number','quantity', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('quantity', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('section_teacher_id') ? 'has-error' : '' }}">
            {!! Form::label('section_teacher_id', trans('section.teacher'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('section_teacher_id', $teachers, null, array('id'=>'section_teacher_id', 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('section_teacher_id', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('session_id') ? 'has-error' : '' }}">
            {!! Form::label('session_id', trans('section.session_id'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('session_id', $sessions, null, array('id'=>'session_id', 'class' => 'form-control
                select2')) !!}
                <span class="help-block">{{ $errors->first('session_id', ':message') }}</span>
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
