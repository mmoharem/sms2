<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        @if (isset($timetablePeriod))
            {!! Form::model($timetablePeriod, array('url' => url($type) . '/' . $timetablePeriod->id, 'method' => 'put', 'class' => 'bf', 'files'=> true)) !!}
        @else
            {!! Form::open(array('url' => url($type), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
        @endif
        <div class="form-group required {{ $errors->has('start_at') ? 'has-error' : '' }}">
            {!! Form::label('start_at', trans('timetable_period.start_at'), array('class' => 'control-label required')) !!}
            <div class="controls" style="position: relative">
                {!! Form::text('start_at', null, array('class' => 'form-control time')) !!}
                <span class="help-block">{{ $errors->first('start_at', ':message') }}</span>
            </div>
        </div>
            <div class="form-group required {{ $errors->has('end_at') ? 'has-error' : '' }}">
                {!! Form::label('end_at', trans('timetable_period.end_at'), array('class' => 'control-label required')) !!}
                <div class="controls" style="position: relative">
                    {!! Form::text('end_at', null, array('class' => 'form-control time')) !!}
                    <span class="help-block">{{ $errors->first('end_at', ':message') }}</span>
                </div>
            </div>
        <div class="form-group required {{ $errors->has('title') ? 'has-error' : '' }}">
            {!! Form::label('title', trans('timetable_period.title'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('title', null, array('class' => 'form-control')) !!}
                {!! Form::label('title_note', trans('timetable_period.title_note'), array('class' => 'control-label')) !!}
                <span class="help-block">{{ $errors->first('title', ':message') }}</span>
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
