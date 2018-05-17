<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        @if (isset($staffLeave))
            {!! Form::model($staffLeave, array('url' => url($type) . '/' . $staffLeave->id, 'method' => 'put')) !!}
        @else
            {!! Form::open(array('url' => url($type), 'method' => 'post')) !!}
        @endif
        <div class="form-group {{ $errors->has('date') ? 'has-error' : '' }}">
            {!! Form::label('date', trans('staff_leave.date'), array('class' => 'control-label required')) !!}
            <div class="controls" style="position: relative">
                {!! Form::text('date', null, array('class' => 'form-control date')) !!}
                <span class="help-block">{{ $errors->first('date', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('staff_leave_type_id') ? 'has-error' : '' }}">
            {!! Form::label('text', trans('staff_leave.staff_leave_type_id'), array('class' => 'control-label required')) !!}
            <div class="controls">
                <div class="controls">
                    {!! Form::select('staff_leave_type_id', $staff_leave_types, null, array('id'=>'staff_leave_type_id', 'class' => 'form-control select2')) !!}
                </div>
            </div>
        </div>
        <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
            {!! Form::label('description', trans('staff_leave.description'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('description', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('description', ':message') }}</span>
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
