<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label class="control-label" for="title">{{trans('semester.title')}}</label>
            <div class="controls">
                @if (isset($semester))
                    {{ $semester->title }}
                @endif
            </div>
        </div>
        @if (!is_null($semester->school))
            <div class="form-group">
                <label class="control-label" for="school">{{trans('semester.school')}}</label>
                <div class="controls">
                    {{ $semester->school->title }}
                </div>
            </div>
        @endif
        <div class="form-group">
            <label class="control-label" for="direction">{{trans('semester.school_year')}}</label>
            <div class="controls">
                @if (isset($semester) && isset($semester->school_year))
                    {{ $semester->school_year->title }}
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="start">{{trans('semester.start')}}</label>
            <div class="controls">
                @if (isset($semester))
                    {{ $semester->start }}
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="end">{{trans('semester.end')}}</label>
            <div class="controls">
                @if (isset($semester))
                    {{ $semester->end }}
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