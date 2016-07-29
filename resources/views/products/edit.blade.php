@extends('layouts.default')

@section('content')
	<h1>Edit Product</h1>
	<hr>
	<div class="col-md-6">
		{!! Form::model($product, ['method' => 'PATCH', 'action' => ['ProductsController@update', $product->id]]) !!}
			@include('products.form', ['submitButtonText' => 'Edit Product'])
		{{Form::close()}}
	</div>
	<div class="col-md-6">
		@include('errors.form-errors')
	</div>
@stop