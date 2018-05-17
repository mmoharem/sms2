<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label class="control-label" for="user_id">{{trans('block_login.user_id')}}</label>
            <div class="controls">
                @if (isset($blockLogin->user))
                    {{ $blockLogin->user->full_name }}
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="date">{{trans('block_login.date')}}</label>
            <div class="controls">
                @if (isset($blockLogin))
                    {{ $blockLogin->created_at->format(Settings::get('date_format')) }}
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