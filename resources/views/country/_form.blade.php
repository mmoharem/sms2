<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        @if (isset($country))
            {!! Form::model($country, array('url' => url($type) . '/' . $country->id, 'method' => 'put', 'class' => 'bf', 'files'=> true)) !!}
        @else
            {!! Form::open(array('url' => url($type), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
        @endif
        <div class="form-group required {{ $errors->has('name') ? 'has-error' : '' }}">
            {!! Form::label('name', trans('country.name'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('name', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('name', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('sortname') ? 'has-error' : '' }}">
            {!! Form::label('sortname', trans('country.sortname'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('sortname', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('sortname', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('nationality') ? 'has-error' : '' }}">
            {!! Form::label('nationality', trans('country.nationality'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('nationality', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('nationality', ':message') }}</span>
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
