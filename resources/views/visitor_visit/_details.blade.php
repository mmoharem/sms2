<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label class="control-label" for="title">{{trans('visitor_visit.full_name')}}</label>
            <div class="controls">
                @if (isset($visitorLog->user)) {{ $visitorLog->user->full_name }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('visitor_visit.visited_user')}}</label>
            <div class="controls">
                @if (isset($visitorLog->visited_user)) {{ $visitorLog->visited_user->full_name }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="check_in">{{trans('visitor_visit.check_in')}}</label>
            <div class="controls">
                @if (isset($visitorLog)) {{ $visitorLog->check_in }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="check_out">{{trans('visitor_visit.check_out')}}</label>
            <div class="controls">
                @if (isset($visitorLog)) {{ $visitorLog->check_out }} @endif
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