<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label class="control-label" for="title">{{trans('staff_leave_type.title')}}</label>
            <div class="controls">
                @if (isset($staffLeaveType)) {{ $staffLeaveType->title }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="max_days">{{trans('staff_leave_type.max_days')}}</label>
            <div class="controls">
                @if (isset($staffLeaveType)) {{ $staffLeaveType->max_days }} @endif
            </div>
        </div>
        <div class="form-group">
            <div class="controls">
                @if (@$action == 'show')
                    <a href="{{ url($type) }}" class="btn btn-primary btn-sm">{{trans('table.close')}}</a>
                @else
                    <a href="{{ url($type) }}" class="btn btn-primary btn-sm">{{trans('table.cancel')}}</a>
                    <button type="submit" class="btn btn-danger btn-sm">{{trans('table.delete')}}</button>
                @endif
            </div>
        </div>
    </div>
</div>