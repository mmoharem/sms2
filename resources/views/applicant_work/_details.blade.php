<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label class="control-label" for="title">{{trans('applicant_work.company')}}</label>
            <div class="controls">
                @if (isset($applicantWork))
                    {{ $applicantWork->company }}
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('applicant_work.position')}}</label>
            <div class="controls">
                @if (isset($applicantWork))
                    {{ $applicantWork->position }}
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('applicant_work.start_date')}}</label>
            <div class="controls">
                @if (isset($applicantWork))
                    {{ $applicantWork->start_date }}
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('applicant_work.end_date')}}</label>
            <div class="controls">
                @if (isset($applicantWork))
                    {{ (($applicantWork->end_date=='0000-00-00')?"-":$applicantWork->end_date) }}
                @endif
            </div>
        </div>
        <div class="form-group">
            <div class="controls">
                @if (@$action == 'show')
                    <a href="{{ url($type) }}" class="btn btn-primary btn-sm">{{trans('table.close')}}</a>
                @else
                    <a href="{{ url($type) }}" class="btn btn-primary btn-sm">{{trans('table.cancel')}}</a>
                    <button type="submit" class="btn btn-danger btn-sm">{{trans('table.delete')}}</button>
                @endif
            </div>
        </div>
    </div>
</div>