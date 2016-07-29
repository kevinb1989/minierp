@extends('layouts.default')

@section('title')
	Edit Item
@stop

@section('content')
<h1>Edit Item</h1>
<hr>
<div class="col-md-6">
	{!! Form::model($item, ['method' => 'PATCH', 'action' => ['ItemsController@update', $item->id]]) !!}
	<div class="form-group">
		{{Form::label('sku', 'sku:')}}
		@if($item->status == 'Available')
			{{Form::select('product_id', $products, $item->product->id, ['class' => 'form-control'])}}
		@else
			<strong>{{$item->product->sku}}</strong>
			{{Form::hidden('product_id', $item->product->id)}}
		@endif

	</div>
	<div class="form-group">
		{{Form::label('status', 'status: ')}} <strong>{{$item->status}}</strong>
		{{Form::hidden('status', $item->status)}}
	</div>
	<div class="form-group">
		{{Form::label('physical_status', 'Physical status: ')}}
		<!-- In case this item is attached to an order, we may change its physical status to Delivered -->
		@if($item->status == 'Assigned')
			{{Form::select('physical_status', ['To order'=>'To order', 'In warehouse'=>'In warehouse', 'Delivered'=>'Delivered'], $item->physical_status, ['class' => 'form-control'])}}
		<!-- In case this item is available, the "Delivered" physical status is not available -->
		@else
			{{Form::select('physical_status', ['To order'=>'To order', 'In warehouse'=>'In warehouse'], $item->physical_status, ['class' => 'form-control'])}}
		@endif
		
	</div>
	<div class="form-group">
		{{Form::submit('edit item', ['class' => 'btn btn-default'])}}
	</div>
	{{Form::close()}}
</div>
<div class="col-md-6">
	@include('errors.form-errors')
</div>
@stop