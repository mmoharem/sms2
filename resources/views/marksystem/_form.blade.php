<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        @if (isset($markSystem))
            {!! Form::model($markSystem, array('url' => url($type) . '/' . $markSystem->id, 'method' => 'put', 'class' => 'bf', 'files'=> true)) !!}
        @else
            {!! Form::open(array('url' => url($type), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
        @endif
        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
            {!! Form::label('title', trans('marksystem.title'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('title', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('title', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('grade_gpa') ? 'has-error' : '' }}">
            {!! Form::label('grade_gpa', trans('marksystem.grade_gpa'), array('class' => 'control-label')) !!}
            <div class="controls">
                <div class="form-inline">
                    <div class="radio">
                        {!! Form::radio('grade_gpa', 'grade',(isset($markSystem) && $markSystem=='grade')?true:false,array('id'=>'grade_gpa','class' => 'about_school_page'))  !!}
                        {!! Form::label('grade', trans('marksystem.grade'))  !!}
                    </div>
                    <div class="radio">
                        {!! Form::radio('grade_gpa', 'gpa', (isset($markSystem) && $markSystem=='grade')?true:false,array('id'=>'grade_gpa','class' => 'about_school_page'))  !!}
                        {!! Form::label('gpa', trans('marksystem.gpa')) !!}
                    </div>
                </div>
                <span class="help-block">{{ $errors->first('grade_gpa', ':message') }}</span>
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
