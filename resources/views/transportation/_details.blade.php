<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label class="control-label" for="title">{{trans('transportation.title')}}</label>
            <div class="controls">
                @if (isset($transportation)) {{ $transportation->title }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('transportation.journey_purpose')}}</label>
            <div class="controls">
                @if (isset($transportation)) {!! $transportation->journey_purpose  !!} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('transportation.vehicle_type')}}</label>
            <div class="controls">
                @if (isset($transportation)) {{ $transportation->vehicle_type }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('transportation.fee')}}</label>
            <div class="controls">
                @if (isset($transportation)) {{ $transportation->fee }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('transportation.start')}}</label>
            <div class="controls">
                @if (isset($transportation)) {{ $transportation->start }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('transportation.end')}}</label>
            <div class="controls">
                @if (isset($transportation)) {{ $transportation->end }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('transportation.locations')}}</label>
            <div class="controls">
                <ul>
                    @foreach($transportation->locations as $location)
                        <li>{{ $location->name  }}</li>
                    @endforeach
                </ul>
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