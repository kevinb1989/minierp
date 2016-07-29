@extends('layouts.default')

@section('title')
	An order from {{$order->customer_name}}
@stop

@section('content')
	<h1>Order Information</h1>
	<hr>
		<p><strong>Customer:</strong> {{$order->customer_name}}</p>
		<p><strong>Address:</strong> {{$order->address}}</p>
		<p><strong>Order date:</strong> {{$order->created_at->toDayDateTimeString()}}</p>
		<p><strong>Status:</strong> {{$order->status}}</p>
	<hr>
	<table id="items-table" class="display" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th>No.</th>
				<th>sku</th>
				<th>colour</th>
				<th>status</th>
				<th>physical status</th>
				<th>created at</th>
				<th>Edit</th>
			</tr>
		</thead>
		<tbody>
			@foreach($order->items as $item)
				<tr>
					<td>{{$item->id}}</td>
					<td>{{$item->product->sku}}</td>
					<td>{{$item->product->colour}}</td>
					<td>{{$item->status}}</td>
					<td>{{$item->physical_status}}</td>
					<td>{{$item->created_at->toDayDateTimeString()}}</td>
					<td>{{link_to('items/' . $item->id . '/edit', 'Edit', ['class'=>'btn btn-xs btn-primary'])}}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@stop

@section('custom_script')
	<script type="text/javascript">
		$(document).ready(function(){
    		$('#items-table').DataTable({
    			"order": [[ 5, "desc" ]]
    		});
		});
	</script>
@stop