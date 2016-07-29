<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use \Mockery;
use MiniErp\Repositories\ProductRepository;

class ProductRepositoryTest extends TestCase
{
	private $products;
	private $productRepository;

	public function setUp(){
		parent::setUp();

		$this->products = Mockery::mock('MiniErp\Entities\Product');
		$this->productRepo = new ProductRepository($this->products);
	}

	/** @test */
    public function it_will_return_a_list_of_all_products()
    {
        $builder = Mockery::mock('Illuminate\Database\Query\Builder');
    	
        $this->products->shouldReceive('latest')
            ->once()
            ->andReturn($builder);

        $builder->shouldReceive('get')->once();

    	$productList = $this->productRepo->getAllProducts();
    }

    /** @test */
    public function it_will_add_a_new_product(){
    	$input = [
    		'sku' => 'product1',
    		'colour' => 'red'
    	];

    	$this->products->shouldReceive('create')
    		->once()
    		->with($input);

    	$product = $this->productRepo->addProduct($input);
    }

    /** @test */
    public function it_will_edit_an_existing_product(){
    	$input = [
    		'id' => 2,
    		'sku' => 'product2',
    		'colour' => 'blue'
    	];

        $builder = Mockery::mock('Illuminate\Database\Eloquent\Builder');

    	$this->products->shouldReceive('where')
            ->once()
            ->andReturn($builder);

        $builder->shouldReceive('update')->once();

    	$updated = $this->productRepo->editProduct($input);
    }

    /** @test */
    public function it_will_return_a_product_by_its_id(){
        $this->products->shouldReceive('find')
            ->once()
            ->with(1);

        $this->productRepo->findProductById(1);
    }

    public function tearDown(){
    	Mockery::close();
    }
}
