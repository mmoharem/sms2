@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
	{{ $title }}
@stop

{{-- Content --}}
@section('content')
    <link rel="stylesheet" href="{{ asset('css/c3.min.css') }}">
    <script type="text/javascript" src="{{ asset('js/d3.v3.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/d3.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/c3.min.js')}}"></script>
    <div class="row">
        <div class="col-sm-6">
            @include('charts.invoice_payment_stats')
        </div>
        <div class="col-sm-6">
            @include('charts.invoice_payment_stats_sum')
        </div>
    </div>
	<div class=" clearfix">
		@if(!Sentinel::getUser()->inRole('admin') ||
		(Sentinel::getUser()->inRole('admin') && Settings::get('multi_school') == 'no') ||
		(Sentinel::getUser()->inRole('admin') && $user->authorized($type.'.create')))
			<div class="pull-right">
				<a href="{{ url($type.'/create') }}" class="btn btn-sm btn-primary">
					<i class="fa fa-plus-circle"></i> {{ trans('table.new') }}</a>
			</div>
		@endif
	</div>
	<table id="data" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
		<thead>
		<tr>
			<th>{{ trans('invoice.full_name') }}</th>
			<th>{{ trans('invoice.arrears') }}</th>
			<th>{{ trans('invoice.paid') }}</th>
			<th>{{ trans('invoice.balance') }}</th>
			<th>{{ trans('invoice.currency') }}</th>
			<th>{{ trans('table.actions') }}</th>
		</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
@stop

{{-- Scripts --}}
@section('scripts')

@stop