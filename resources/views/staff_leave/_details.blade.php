<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label class="control-label" for="date">{{trans('staff_leave.date')}}</label>
            <div class="controls">
                {{ $staffLeave->date }}
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="description">{{trans('staff_leave.description')}}</label>
            <div class="controls">
               {{ $staffLeave->description }}
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="description">{{trans('staff_leave.staff_leave_type')}}</label>
            <div class="controls">
               {{ $staffLeave->staff_leave_type->title }}
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