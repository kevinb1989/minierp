@extends('layouts.default')

@section('title')
	orders
@stop

@section('content')
	<h1>All Orders</h1>
	<hr>
	<table id="orders-table" class="display" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th>No.</th>
				<th>customer name</th>
				<th>address</th>
				<th>status</th>
				<th>order date</th>
				<th>edit</th>
			</tr>
		</thead>
		<tbody>
			@foreach($orders as $order)
				<tr>
					<td>{{$order->id}}</td>
					<td>{{$order->customer_name}}</td>
					<td>{{$order->address}}</td>
					<td>{{$order->status}}</td>
					<td>{{$order->created_at->toDayDateTimeString()}}</td>
					<td>{{link_to('orders/' . $order->id . '/edit', 'Edit', ['class'=>'btn btn-xs btn-primary'])}}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@stop

@section('custom_script')
	<script type="text/javascript">
		$(document).ready(function(){
    		$('#orders-table').DataTable({
    			"order": [[ 4, "desc" ]]
    		});
		});
	</script>
@stop