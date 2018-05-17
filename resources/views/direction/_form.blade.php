<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        @if (isset($direction))
            {!! Form::model($direction, array('url' => url($type) . '/' . $direction->id, 'method' => 'put', 'class' => 'bf', 'files'=> true)) !!}
        @else
            {!! Form::open(array('url' => url($type), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
        @endif
        <div class="form-group required {{ $errors->has('title') ? 'has-error' : '' }}">
            {!! Form::label('title', trans('direction.title'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('title', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('title', ':message') }}</span>
            </div>
        </div>
        <div class="form-group  {{ $errors->has('department_id') ? 'has-error' : '' }}">
            {!! Form::label('department_id', trans('direction.department'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('department_id', $departments, null, array('class' => 'form-control',
                'placeholder'=>trans('direction.select_department')))!!}
                <span class="help-block">{{ $errors->first('department_id', ':message') }}</span>
            </div>
        </div>
        <div class="form-group  {{ $errors->has('code') ? 'has-error' : '' }}">
            {!! Form::label('code', trans('direction.code'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('code', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('code', ':message') }}</span>
            </div>
        </div>
        <div class="form-group  {{ $errors->has('duration') ? 'has-error' : '' }}">
            {!! Form::label('duration', trans('direction.duration'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::input('number','duration', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('duration', ':message') }}</span>
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
