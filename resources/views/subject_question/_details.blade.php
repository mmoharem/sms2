<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label class="control-label" for="title">{{trans('subject_question.title')}}</label>
            <div class="controls">
                @if (isset($subjectQuestion))
                    {{ $subjectQuestion->title }}
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('subject_question.content')}}</label>
            <div class="controls">
                @if (isset($subjectQuestion))
                    {!!  $subjectQuestion->content  !!}
                @endif
            </div>
        </div>
        <div class="row">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <td>{{trans('subject_question.response')}}</td>
                        <td>{{trans('subject_question.user')}}</td>
                        <td>{{trans('subject_question.time')}}</td>
                    </tr>
                </thead>
                <tbody>
                @foreach($subjectQuestion->answers as $item)
                    <tr>
                        <td>{!! $item->content !!}</td>
                        <td>{{$item->user->full_name}}</td>
                        <td>{{$item->created_at->format(Settings::get('date_format'). ' '. Settings::get('time_format'))}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @if (@$action == 'show')
            {!! Form::open(array('url' => url($type.'/'.$subjectQuestion->id.'/replay'), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
            <div class="row">
                <div class="form-group {{ $errors->has('content') ? 'has-error' : '' }}">
                    {!! Form::label('content', trans('subject_question.answer'), array('class' => 'control-label required')) !!}
                    <div class="controls">
                        {!! Form::textarea('content', null, array('class' => 'form-control')) !!}
                        <span class="help-block">{{ $errors->first('content', ':message') }}</span>
                    </div>
                </div>
            </div>
        @endif
            <div class="form-group">
                <div class="controls">
                    @if (@$action == 'show')
                    <button type="submit" class="btn btn-success btn-sm">{{trans('subject_question.replay')}}</button>
                    <a href="{{ url($type) }}" class="btn btn-primary btn-sm">{{trans('table.close')}}</a>
                    @else
                        <a href="{{ url($type) }}" class="btn btn-primary btn-sm">{{trans('table.cancel')}}</a>
                        <button type="submit" class="btn btn-danger btn-sm">{{trans('table.delete')}}</button>
                    @endif
                </div>
            </div>
            {!! Form::close() !!}
    </div>
</div>