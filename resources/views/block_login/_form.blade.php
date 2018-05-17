<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        @if (isset($blockLogin))
            {!! Form::model($blockLogin, array('url' => url($type) . '/' . $blockLogin->id, 'method' => 'put', 'class' => 'bf', 'files'=> true)) !!}
        @else
            {!! Form::open(array('url' => url($type), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
        @endif
            <div class="form-group  {{ $errors->has('user_id') ? 'has-error' : '' }}">
                {!! Form::label('user_id', trans('block_login.user_id'), array('class' => 'control-label required')) !!}
                <div class="controls">
                    {!! Form::select('user_id', $users, null, array('class' => 'form-control select2')) !!}
                    <span class="help-block">{{ $errors->first('user_id', ':message') }}</span>
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
