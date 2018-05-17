@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    <div class=" clearfix">
        @if($user->inRole( 'student' ))
            <div class="pull-right">
                <a href="{{ url($type.'/create') }}" class="btn btn-sm btn-primary">
                    <i class="fa fa-plus-circle"></i> {{ trans('table.new') }}</a>
            </div>
        @endif
        <div class="row">
            <div class="col-sm-3">
                {!! Form::select('subject_id', $subjects, null, array('id'=>'subject_id', 'class' => 'form-control select2')) !!}
            </div>
        </div>
    </div>
    <table id="data" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>{{ trans('subject_question.subject') }}</th>
            <th>{{ trans('subject_question.title') }}</th>
            <th>{{ trans('subject_question.student') }}</th>
            <th>{{ trans('table.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
@stop

{{-- Scripts --}}
@section('scripts')
    <script>
        $(document).ready(function () {
            $('#subject_id').change(function(){
                if ($("#subject_id option:selected").val() > 0) {
                    $('#data').DataTable().ajax.url('{!! url($type.'/data/') !!}/' + $("#subject_id option:selected").val());
                    $('#data').DataTable().ajax.reload();
                }
            });
        });
    </script>
@stop