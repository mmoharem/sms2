<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label class="control-label" for="title">{{trans('kitchen_staff.first_name')}}</label>
            <div class="controls">
                @if (isset($kitchen_staff)) {{ $kitchen_staff->first_name }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('kitchen_staff.last_name')}}</label>
            <div class="controls">
                @if (isset($kitchen_staff)) {{ $kitchen_staff->last_name }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('kitchen_staff.email')}}</label>
            <div class="controls">
                @if (isset($kitchen_staff)) {{ $kitchen_staff->email }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('kitchen_staff.gender')}}</label>
            <div class="controls">
                @if (isset($kitchen_staff)) {{ ($kitchen_staff->gender==1)?trans('kitchen_staff.male'):trans('kitchen_staff.female') }} @endif
            </div>
        </div>
        @if(is_array($custom_fields))
            @foreach($custom_fields as $item)
                <div class="form-group">
                    <label class="control-label" for="title">{{ucfirst($item->name)}}</label>
                    <div class="controls">
                        {{ $item->value }}
                    </div>
                </div>
            @endforeach
        @endif
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