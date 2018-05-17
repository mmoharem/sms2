<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        @if (isset($visitorLog))
            {!! Form::model($visitorLog, array('url' => url($type) . '/' . $visitorLog->id, 'method' => 'put', 'class' => 'bf', 'files'=> true)) !!}
        @else
            {!! Form::open(array('url' => url($type), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
        @endif
            <div class="form-group required {{ $errors->has('user_id') ? 'has-error' : '' }}">
                {!! Form::label('user_id', trans('visitor_visit.visitor'), array('class' => 'control-label required')) !!}
                <div class="controls">
                    {!! Form::select('user_id', $visitors, null, array('id'=>'user_id', 'class' => 'form-control select2')) !!}
                    <span class="help-block">{{ $errors->first('user_id', ':message') }}</span>
                </div>
            </div>
            <div class="form-group required {{ $errors->has('visited_user_id') ? 'has-error' : '' }}">
                {!! Form::label('visited_user_id', trans('visitor_visit.visited_user'), array('class' => 'control-label required')) !!}
                <div class="controls">
                    {!! Form::select('visited_user_id', $visited_user, null, array('id'=>'visited_user_id', 'class' => 'form-control select2')) !!}
                    <span class="help-block">{{ $errors->first('visited_user_id', ':message') }}</span>
                </div>
            </div>
        <div class="form-group required {{ $errors->has('check_in') ? 'has-error' : '' }}">
            {!! Form::label('check_in', trans('visitor_visit.check_in'), array('class' => 'control-label required')) !!}
            <div class="controls" style="position: relative">
                {!! Form::text('check_in', null, array('class' => 'form-control datetime')) !!}
                <span class="help-block">{{ $errors->first('check_in', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('check_out') ? 'has-error' : '' }}">
            {!! Form::label('check_out', trans('visitor_visit.check_out'), array('class' => 'control-label')) !!}
            <div class="controls" style="position: relative">
                {!! Form::text('check_out', null, array('class' => 'form-control datetime')) !!}
                <span class="help-block">{{ $errors->first('check_out', ':message') }}</span>
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