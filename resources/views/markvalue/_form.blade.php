<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        @if (isset($markValue))
            {!! Form::model($markValue, array('url' => url($type) . '/' . $markValue->id, 'method' => 'put', 'class' => 'bf', 'files'=> true)) !!}
        @else
            {!! Form::open(array('url' => url($type), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
        @endif
        <div class="form-group  {{ $errors->has('mark_system_id') ? 'has-error' : '' }}">
            {!! Form::label('mark_system_id', trans('markvalue.mark_system'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('mark_system_id', $mark_systems, null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('mark_system_id', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('max_score') ? 'has-error' : '' }}">
            {!! Form::label('max_score', trans('markvalue.max_score'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('max_score', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('max_score', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('min_score') ? 'has-error' : '' }}">
            {!! Form::label('min_score', trans('markvalue.min_score'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('min_score', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('min_score', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('grade') ? 'has-error' : '' }}">
            {!! Form::label('grade', trans('markvalue.grade'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('grade', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('grade', ':message') }}</span>
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