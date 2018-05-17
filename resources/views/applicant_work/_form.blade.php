<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        @if (isset($applicantWork))
            {!! Form::model($applicantWork, array('url' => url($type) . '/' . $applicantWork->id, 'method' => 'put', 'class' => 'bf', 'files'=> true)) !!}
        @else
            {!! Form::open(array('url' => url($type), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
        @endif
        <div class="form-group required {{ $errors->has('company') ? 'has-error' : '' }}">
            {!! Form::label('company', trans('applicant_work.company'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('company', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('company', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('position') ? 'has-error' : '' }}">
            {!! Form::label('position', trans('applicant_work.position'), array('class' => 'control-label required')) !!}
            <div class="controls" style="position: relative">
                {!! Form::text('position', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('position', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('start_date') ? 'has-error' : '' }}">
            {!! Form::label('start_date', trans('applicant_work.start_date'), array('class' => 'control-label required')) !!}
            <div class="controls" style="position: relative">
                {!! Form::text('start_date', null, array('class' => 'form-control date')) !!}
                <span class="help-block">{{ $errors->first('start_date', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('end_date') ? 'has-error' : '' }}">
            {!! Form::label('end_date', trans('applicant_work.end_date'), array('class' => 'control-label required')) !!}
            <div class="controls" style="position: relative">
                {!! Form::text('end_date', null, array('class' => 'form-control date')) !!}
                <span class="help-block">{{ $errors->first('end_date', ':message') }}</span>
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
