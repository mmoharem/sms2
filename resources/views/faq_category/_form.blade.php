<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        @if (isset($faqCategory))
            {!! Form::model($faqCategory, array('url' => url($type) . '/' . $faqCategory->id, 'method' => 'put', 'class' => 'bf', 'files'=> true)) !!}
        @else
            {!! Form::open(array('url' => url($type), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
        @endif
        <div class="form-group required {{ $errors->has('title') ? 'has-error' : '' }}">
            {!! Form::label('title', trans('faq_category.title'), array('class' => 'control-label required')) !!}
            <div class="controls">
                {!! Form::text('title', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('title', ':message') }}</span>
            </div>
        </div>
            <div class="form-group  {{ $errors->has('role_id') ? 'has-error' : '' }}">
                {!! Form::label('role_id', trans('faq_category.for_role'), array('class' => 'control-label required')) !!}
                <div class="controls">
                    {!! Form::select('role_id', $roles, null, array('class' => 'form-control select2', 'placeholder'=>trans('faq_category.public')))
                     !!}
                    <span class="help-block">{{ $errors->first('role_id', ':message') }}</span>
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
