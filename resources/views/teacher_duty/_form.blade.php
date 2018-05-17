<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        @if (isset($teacherDuty))
            {!! Form::model($teacherDuty, array('url' => url($type) . '/' . $teacherDuty->id, 'method' => 'put', 'class' => 'bf', 'files'=> true)) !!}
        @else
            {!! Form::open(array('url' => url($type), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
        @endif
        <div class="form-group  {{ $errors->has('user_id') ? 'has-error' : '' }}">
            {!! Form::label('user_id', trans('teacher_duty.teacher'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('user_id', $users, null, array('class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('user_id', ':message') }}</span>
            </div>
        </div>
            <div class="form-group  {{ $errors->has('day_night') ? 'has-error' : '' }}">
            {!! Form::label('day_night', trans('teacher_duty.day_night'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::select('day_night', $day_night, null, array('class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('day_night', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('start_date') ? 'has-error' : '' }}">
            {!! Form::label('start_date', trans('teacher_duty.start_date'), array('class' => 'control-label required')) !!}
            <div class="controls" style="position: relative">
                {!! Form::text('start_date', null, array('class' => 'form-control date')) !!}
                <span class="help-block">{{ $errors->first('start_date', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('end_date') ? 'has-error' : '' }}">
            {!! Form::label('end_date', trans('teacher_duty.end_date'), array('class' => 'control-label required')) !!}
            <div class="controls" style="position: relative">
                {!! Form::text('end_date', null, array('class' => 'form-control date')) !!}
                <span class="help-block">{{ $errors->first('end_date', ':message') }}</span>
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
