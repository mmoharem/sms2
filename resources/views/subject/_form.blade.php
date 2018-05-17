<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        @if (isset($subject))
            {!! Form::model($subject, array('url' => url($type) . '/' . $subject->id, 'method' => 'put', 'class' => 'bf', 'files'=> true)) !!}
        @else
            {!! Form::open(array('url' => url($type), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
        @endif
        <div class="form-group required {{ $errors->has('title') ? 'has-error' : '' }}">
            {!! Form::label('title', trans('table.title'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('title', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('title', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('code') ? 'has-error' : '' }}">
            {!! Form::label('code', trans('subject.code'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('code', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('code', ':message') }}</span>
            </div>
        </div>
        <div class="form-group required {{ $errors->has('credit_hours') ? 'has-error' : '' }}">
            {!! Form::label('credit_hours', trans('subject.credit_hours'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('credit_hours', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('credit_hours', ':message') }}</span>
            </div>
        </div>
        <div class="form-group  {{ $errors->has('direction_id') ? 'has-error' : '' }}">
            {!! Form::label('direction_id', trans('subject.direction'), array('class' => 'control-label required')) !!}
            <div class="controls">
                @if (isset($subject))
                    {!! Form::select('direction_id', $directions, null, ['class'=>'form-control select2'])!!}
                @else
                {!! Form::select('direction_id[]', $directions, null, ['multiple'=>'multiple', 'class'
                =>'form-control select2']) !!}
                @endif
                <span class="help-block">{{ $errors->first('direction_id', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('level_id') ? 'has-error' : '' }}">
            {!! Form::label('level_id', trans('student.level'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::select('level_id', $levels, null, array('id'=>'level_id', 'class' => 'form-control select2')) !!}
                <span class="help-block">{{ $errors->first('level_id', ':message') }}</span>
            </div>
        </div>
        <div class="form-group  {{ $errors->has('order') ? 'has-error' : '' }}">
            {!! Form::label('order', trans('subject.order'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::input('number','order', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('order', ':message') }}</span>
            </div>
        </div>
        <div class="form-group  {{ $errors->has('highest_mark') ? 'has-error' : '' }}">
            {!! Form::label('highest_mark', trans('subject.highest_mark'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::input('number','highest_mark', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('highest_mark', ':message') }}</span>
            </div>
        </div>
        <div class="form-group  {{ $errors->has('lowest_mark') ? 'has-error' : '' }}">
            {!! Form::label('lowest_mark', trans('subject.lowest_mark'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::input('number','lowest_mark', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('lowest_mark', ':message') }}</span>
            </div>
        </div>
        <div class="form-group  {{ $errors->has('class') ? 'has-error' : '' }}">
            {!! Form::label('class', trans('subject.class'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::input('number','class', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('class', ':message') }}</span>
            </div>
        </div>
        <div class="form-group  {{ $errors->has('mark_system_id') ? 'has-error' : '' }}">
            {!! Form::label('mark_system_id', trans('subject.mark_system'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::select('mark_system_id', array('' => trans('subject.select_mark_system')) + $mark_systems, null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('mark_system_id', ':message') }}</span>
            </div>
        </div>
       @if(intval(Settings::get('number_of_semesters')) > 0)
            <div class="form-group">
                {!! Form::label('semester_id', trans('subject.semester'), array('class' => 'control-label'))!!}
                <div class="controls">
                    <select name="semester_id" class="form-control">
                        <option>{{trans('subject.all_over_school_year')}}</option>
                        @for($i=1; $i<=intval(Settings::get('number_of_semesters')); $i++)
                            <option @if (isset($subject->order) && $subject->order == $i) selected @endif
                                        value="{{$i}}">{{$i}}
                            </option>
                        @endfor
                    </select>
                </div>
            </div>
        @endif
        <div class="form-group  {{ $errors->has('fee') ? 'has-error' : '' }}">
            {!! Form::label('fee', trans('subject.fee_form'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::input('number','fee', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('fee', ':message') }}</span>
            </div>
        </div>
        <div class="form-group  {{ $errors->has('short_name') ? 'has-error' : '' }}">
            {!! Form::label('short_name', trans('subject.short_name'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('short_name', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('short_name', ':message') }}</span>
            </div>
        </div>
        <div class="form-group  {{ $errors->has('room') ? 'has-error' : '' }}">
            {!! Form::label('room', trans('subject.room'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::input('number','room', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('room', ':message') }}</span>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('description', trans('subject.description'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::textarea('description', null, array('class' => 'form-control')) !!}
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

