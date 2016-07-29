<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

use MiniErp\Entities\Product;

class UpdateProductRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $product = Product::find($this->products);

        return [
            'sku' => 'required|unique:products,sku,' . $product->id,
            'colour' => 'required'
        ];
    }
}
