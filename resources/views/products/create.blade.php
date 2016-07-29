@extends('layouts.default')

@section('content')
	<h1>Create a new Product</h1>
	<hr>
	<div class="col-md-6">
		{{Form::open(['url' => 'products'])}}
			@include('products.form', ['submitButtonText' => 'Add Product'])
		{{Form::close()}}
	</div>
	<div class="col-md-6">
		@include('errors.form-errors')
	</div>
@stop