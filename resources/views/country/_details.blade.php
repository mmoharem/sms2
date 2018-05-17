<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label class="control-label" for="name">{{trans('country.name')}}</label>
            <div class="controls">
                @if (isset($country))
                    {{ $country>name }}
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="sortname">{{trans('country.sortname')}}</label>
            <div class="controls">
                @if (isset($country))
                    {{ $country>sortname }}
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="nationality">{{trans('country.nationality')}}</label>
            <div class="controls">
                @if (isset($country))
                    {{ $country>nationality }}
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