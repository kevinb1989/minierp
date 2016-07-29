@extends('layouts.default')

@section('title')
	items
@stop

@section('content')
	<h1>All Items</h1>
	<hr>
	<p>{{link_to('items/create', 'Add Item', ['class'=>'btn btn-lg btn-success'])}}</p>
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
			@foreach($items as $item)
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