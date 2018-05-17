<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label class="control-label" for="title">{{trans('teacher_duty.teacher')}}</label>
            <div class="controls">
                @if (!is_null($teacherDuty->user)) {{ $teacherDuty->user->full_name_email }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('teacher_duty.start_date')}}</label>
            <div class="controls">
                @if (isset($teacherDuty)) {{ $teacherDuty->start_date }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('teacher_duty.end_date')}}</label>
            <div class="controls">
                @if (isset($teacherDuty)) {{ $teacherDuty->end_date }} @endif
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