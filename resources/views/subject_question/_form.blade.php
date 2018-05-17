<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        {!! Form::open(array('url' => url($type), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
        <div class="form-group {{ $errors->has('subject_id') ? 'has-error' : '' }}">
            {!! Form::label('subject_id', trans('subject_question.subject'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('subject_id', $subjects, null, array('id'=>'subject_id', 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('subject_id', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
            {!! Form::label('title', trans('subject_question.title'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('title', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('title', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('content') ? 'has-error' : '' }}">
            {!! Form::label('content', trans('subject_question.content'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::textarea('content', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('content', ':message') }}</span>
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
