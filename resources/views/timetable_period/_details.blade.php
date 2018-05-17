<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label class="control-label" for="title">{{trans('timetable_period.start_at')}}</label>
            <div class="controls">
                @if (isset($timetablePeriod))
                    {{ $timetablePeriod->start_at }}
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('timetable_period.end_at')}}</label>
            <div class="controls">
                @if (isset($timetablePeriod))
                    {{ $timetablePeriod->end_at }}
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('timetable_period.title')}}</label>
            <div class="controls">
                @if (isset($timetablePeriod))
                    {{ $timetablePeriod->title }}
                @endif
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