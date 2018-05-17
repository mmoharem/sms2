<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label class="control-label" for="title">{{trans('meal.title')}}</label>
            <div class="controls">
                @if (isset($meal)) {{ $meal->title }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('meal.meal_type')}}</label>
            <div class="controls">
                @if (!is_null($meal->meal_type)) {{ $meal->meal_type->title }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('meal.serve_start_date')}}</label>
            <div class="controls">
                @if (isset($meal)) {{ $meal->serve_start_date }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('meal.serve_end_date')}}</label>
            <div class="controls">
                @if (isset($meal)) {{ $meal->serve_end_date }} @endif
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