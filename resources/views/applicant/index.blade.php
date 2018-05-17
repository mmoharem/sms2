@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
    {{ $title }}
@stop

{{-- Content --}}
@section('content')
   <div class=" clearfix">
        @if($user->authorized($type.'.create'))
            <div class="pull-right">
                <a href="{{ url($type.'/create') }}" class="btn btn-sm btn-primary">
                    <i class="fa fa-plus-circle"></i> {{ trans('table.new') }}</a>
            </div>
        @endif
    </div>
    @include('applicant.filter')
    <div class="row showajax">
        <table id="data" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>{{ trans('applicant.applicant_id') }}</th>
                <th>{{ trans('applicant.full_name') }}</th>
                <th>{{ trans('applicant.email') }}</th>
                <th>{{ trans('applicant.session') }}</th>
                <th>{{ trans('applicant.order') }}</th>
                <th>{{ trans('table.actions') }}</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
@stop
@section('scripts')
    <script>
        $('.filter').click(function (e) {
            e.stopPropagation();
            let first_name = ($('#first_name').val() == '') ? '*' : $('#first_name').val();
            let last_name = ($('#last_name').val() == '') ? '*' : $('#last_name').val();
            let applicant_id = ($('#applicant_no').val() == '') ? '*' : $('#applicant_no').val();
            let direction_id = ($('#direction_id').val() == '') ? '*' : $('#direction_id').val();
            let country_id = ($('#country_id').val() == '') ? '*' : $('#country_id').val();
            let session_id = ($('#session_id').val() == '') ? '*' : $('#session_id').val();
            let section_id = ($('#section_id').val() == '') ? '*' : $('#section_id').val();
            let level_id = ($('#level_id').val() == '') ? '*' : $('#level_id').val();
            let entry_mode_id = ($('#entry_mode_id').val() == '') ? '*' : $('#entry_mode_id').val();
            let gender = ($('#gender').val() == '') ? '*' : $('#gender').val();
            let marital_status_id =($('#marital_status_id').val() == '') ? '*' :  $('#marital_status_id').val();
            let dormitory_id = ($('#dormitory_id').val() == '') ? '*' : $('#dormitory_id').val();
            $('#data').DataTable().ajax.url('{!! url($type.'/data') !!}/' + first_name + '/' + last_name + '/' + applicant_id + '/' + country_id + '/' + session_id + '/' + direction_id + '/' + section_id + '/' + level_id + '/' + entry_mode_id + '/' + gender + '/' + marital_status_id + '/' + dormitory_id);
            $('#data').DataTable().ajax.reload(null, false);

            return false;
        });
    </script>
@stop
