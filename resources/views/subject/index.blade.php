@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
    <div class=" clearfix">
        <div class="pull-right">
            <a href="{{ url($type.'/create') }}" class="btn btn-sm btn-primary">
                <i class="fa fa-plus-circle"></i> {{ trans('table.new') }}</a>
            <a href="{{ url($type.'/import') }}" class="btn btn-sm btn-success">
                <i class="fa fa-upload"></i> {{trans('subject.import_subject')}}
            </a>
            <a class="btn btn-sm btn-danger" data-href="{{url($type.'/bulk_delete')}}"
               data-toggle="modal" data-target="#confirm-delete">
                <span class="fa fa-remove"></span>  {{trans('subject.delete_all')}}
            </a>
        </div>
    </div>
    <table id="data" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>{{ trans('subject.order') }}</th>
            <th>{{ trans('subject.class') }}</th>
            <th>{{ trans('markvalue.mark_system') }}</th>
            <th>{{ trans('table.title') }}</th>
            <th>{{ trans('subject.code') }}</th>
            <th>{{ trans('subject.credit_hours') }}</th>
            <th>{{ trans('subject.direction') }}</th>
            <th>{{ trans('table.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    {{trans('subject.delete_all')}}
                </div>
                <div class="modal-body">
                    {{trans('subject.delete_all_info')}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('table.cancel')}}</button>
                    <a class="btn btn-danger btn-sm btn-ok">{{trans('table.delete')}}</a>
                </div>
            </div>
        </div>
    </div>
@stop

{{-- Scripts --}}
@section('scripts')
<script>
    $(document).ready(function () {
        $('#confirm-delete').on('show.bs.modal', function (e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });
    });
</script>
@stop