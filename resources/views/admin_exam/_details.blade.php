<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label class="control-label">{{trans('admin_exam.title')}}</label>
            <div class="controls">
                @if (isset($exam)) {{ $exam->title }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label">{{trans('admin_exam.description')}}</label>
            <div class="controls">
                @if (isset($exam)) {{ $exam->description }} @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label">{{trans('admin_exam.date')}}</label>
            <div class="controls">
                @if (isset($exam)) {{ $exam->date }} @endif
            </div>
        </div>
        <div class="form-group">
            <table class="table table-hover">
                <thead>
                <tr>
                    <td>{{trans('admin_exam.group')}}</td>
                    <td>{{trans('admin_exam.subject')}}</td>
                </tr>
                </thead>
                <tbody>
                    @foreach($exam->children as $child)
                        @if(!is_null($child->student_group->title))
                            <tr>
                                <td>{{$child->student_group->title}}</td>
                                <td>{{$child->subject->title}}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="form-group">
            <div class="controls">
                <a href="{{ url($type) }}" class="btn btn-primary btn-sm">{{trans('table.close')}}</a>
            </div>
        </div>
    </div>
</div>