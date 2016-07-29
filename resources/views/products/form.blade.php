<div class="form-group">
	{{Form::label('sku', 'sku: ')}}
	{{Form::text('sku', null, ['class'=>'form-control', 'placeholder'=>'sku'])}}
</div>
<div class="form-group">
	{{Form::label('colour', 'colour: ')}}
	{{Form::text('colour', null, ['class'=>'form-control', 'placeholder'=>'colour'])}}
</div>
<div class="form-group">
	{{Form::submit($submitButtonText, ['class'=>'btn btn-default'])}}
</div>