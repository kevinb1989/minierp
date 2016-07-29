@extends('layouts.default')

@section('content')
<h1>Create a new item</h1>
<hr>
<div class="col-md-6">
	{{Form::open(['url' => 'items'])}}
	<div class="form-group">
		{{Form::label('sku', 'sku:')}}
		{{Form::select('product_id', $products, 1, ['class' => 'form-control'])}}
	</div>
	<div class="form-group">
		{{Form::label('status', 'status: ')}} <strong>Available</strong>
		{{Form::hidden('status', 'Available')}}
	</div>
	<div class="form-group">
		{{Form::label('physical_status', 'Physical status: ')}}
		{{Form::select('physical_status', ['To order'=>'To order', 'In warehouse'=>'In warehouse'], 'To order', ['class' => 'form-control'])}}
	</div>
	<div class="form-group">
		{{Form::submit('add item', ['class' => 'btn btn-default'])}}
	</div>
	{{Form::close()}}
</div>
<div class="col-md-6">
	@include('errors.form-errors')
</div>
@stop