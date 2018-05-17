<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        @if (isset($schoolYear))
            {!! Form::model($schoolYear, array('url' => url($type) . '/' . $schoolYear->id, 'method' => 'put', 'class' => 'bf', 'files'=> true)) !!}
        @else
            {!! Form::open(array('url' => url($type), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
        @endif
         <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
            {!! Form::label('title', trans('schoolyear.title'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('title', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('title', ':message') }}</span>
            </div>
        </div>
            <div class="form-group {{ $errors->has('school_id') ? 'has-error' : '' }}">
                {!! Form::label('school_id', trans('schoolyear.select_school'), array('class' => 'control-label')) !!}
                <div class="controls">
                    {!! Form::select('school_id', $schools_lists, null, array('id'=>'school_id', 'class' => 'form-control select2')) !!}
                    <span class="help-block">{{ $errors->first('school_id', ':message') }}</span>
                </div>
            </div>
            <div class="form-group {{ $errors->has('id_code') ? 'has-error' : '' }}">
            {!! Form::label('id_code', trans('schoolyear.id_code'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('id_code', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('id_code', ':message') }}</span>
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
