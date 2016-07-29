@extends('layouts.default')

@section('title')
	products
@stop

@section('content')
	<h1>All Products</h1>
	<hr>
	<p>{{link_to('products/create', 'Add Product', ['class'=>'btn btn-lg btn-success'])}}</p>
	<hr>
	<table id="products-table" class="display" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th>No.</th>
				<th>sku</th>
				<th>colour</th>
				<th>created at</th>
				<th>edit</th>
			</tr>
		</thead>
		<tbody>
			@foreach($products as $product)
				<tr>
					<td>{{$product->id}}</td>
					<td>{{$product->sku}}</td>
					<td>{{$product->colour}}</td>
					<td>{{$product->created_at->toDayDateTimeString()}}</td>
					<td>{{link_to('products/' . $product->id . '/edit', 'Edit', ['class'=>'btn btn-xs btn-primary'])}}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@stop

@section('custom_script')
	<script type="text/javascript">
		$(document).ready(function(){
    		$('#products-table').DataTable({
    			"order": [[ 3, "desc" ]]
    		});
		});
	</script>
@stop