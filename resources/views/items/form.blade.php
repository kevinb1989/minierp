<div class="form-group">
	{{Form::label('sku', 'sku:')}}
	@if(Session::get('product'))
		{{Form::select('product_id', $products, 1, ['class' => 'form-control'])}}
	@else
		{{Form::select('product_id', $products, $product->id, ['class' => 'form-control'])}}
	@endif
	
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
	{{Form::submit($submitButtonText, ['class' => 'btn btn-default'])}}
</div>