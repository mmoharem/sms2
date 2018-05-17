@extends('layouts.secure')

{{-- Web site Title --}}
@section('title')
	{{ $title }}
@stop

{{-- Content --}}
@section('content')
	<table id="data" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th>{{ trans('table.title') }}</th>
				<th>{{ trans('payment.payment_method') }}</th>
				<th>{{ trans('payment.amount') }}</th>
				<th>{{ trans('payment.status') }}</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
@stop

{{-- Scripts --}}
@section('scripts')

@stop