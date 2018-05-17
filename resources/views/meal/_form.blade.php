<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        @if (isset($meal))
            {!! Form::model($meal, array('url' => url($type) . '/' . $meal->id, 'method' => 'put', 'class' => 'bf', 'files'=> true)) !!}
        @else
            {!! Form::open(array('url' => url($type), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
        @endif
        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
            {!! Form::label('title', trans('meal.title'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('title', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('title', ':message') }}</span>
            </div>
        </div>
        <div class="form-group  {{ $errors->has('meal_type_id') ? 'has-error' : '' }}">
            {!! Form::label('meal_type_id', trans('meal.meal_type'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('meal_type_id', $meal_types, null, array('class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('meal_type_id', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('serve_start_date') ? 'has-error' : '' }}">
            {!! Form::label('serve_start_date', trans('meal.serve_start_date'), array('class' => 'control-label required')) !!}
            <div class="controls" style="position: relative">
                {!! Form::text('serve_start_date', null, array('class' => 'form-control date')) !!}
                <span class="help-block">{{ $errors->first('serve_start_date', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('serve_end_date') ? 'has-error' : '' }}">
            {!! Form::label('serve_end_date', trans('meal.serve_end_date'), array('class' => 'control-label required')) !!}
            <div class="controls" style="position: relative">
                {!! Form::text('serve_end_date', null, array('class' => 'form-control date')) !!}
                <span class="help-block">{{ $errors->first('serve_end_date', ':message') }}</span>
            </div>
        </div>
        <div class="form-group">
            <div class="controls">
                <a href="{{ url($type) }}" class="btn btn-primary btn-sm">{{trans('table.cancel')}}</a>
                <button type="submit" class="btn btn-success btn-sm">{{trans('table.ok')}}</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
