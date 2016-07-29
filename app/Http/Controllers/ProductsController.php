<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use MiniErp\Repositories\ProductRepository;

class ProductsController extends Controller
{
	private $productRepo;

	public function __construct(ProductRepository $productRepo){
		$this->productRepo = $productRepo;
	}

	/**
	 * Return a list of all products
	 * 
	 * @return Illuminate\View\View
	 */
    public function index(){
    	$products = $this->productRepo->getAllProducts();

    	return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created product in storage.
     *
     * @param  App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $newProduct = $this->productRepo->addProduct($request->all());

        flash('A new product with sku: ' . $newProduct->sku . ' has just been created');

        return Redirect('products');
    }

    /**
     * Show the form for editing the specified product.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = $this->productRepo->findProductById($id);

        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified product in storage.
     *
     * @param  App\Http\Requests\UpdateProductRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $input = $request->only(['sku', 'colour']);

        $input['id'] = $id;

        $this->productRepo->editProduct($input);

        flash('A product with sku: ' . $input['sku'] . ' has just been updated');

        return Redirect('products');
    }
}
