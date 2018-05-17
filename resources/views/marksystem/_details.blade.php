<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label class="control-label" for="title">{{trans('marksystem.title')}}</label>
            <div class="controls">
                @if (isset($markSystem)) {{ $markSystem->title }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('marksystem.grade_gpa')}}</label>
            <div class="controls">
                @if (isset($markSystem)) {{ ucfirst($markSystem->grade_gpa) }} @endif
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