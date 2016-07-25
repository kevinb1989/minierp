<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use MiniErp\Entities\Product;
use MiniErp\Repositories\ProductRepository;

class ProductRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    private $productRepo;

    public function setUp(){
    	parent::setUp();

    	$this->productRepo = new ProductRepository(new Product);
    }

    /** @test */
    public function it_will_return_a_list_of_all_products()
    {
        //given
        $products = factory(Product::class, 4)->create();
        
        //when
        $productList = $this->productRepo->getAllProducts();

        //then
        $this->assertEquals(4, $productList->count());
    }

    /** @test */
    public function it_will_add_a_new_product(){
        //given
        $input = [
            'sku' => 'skuproduct453',
            'colour' => 'Green'
        ];

        $newProduct = $this->productRepo->addProduct($input);

        $this->seeInDatabase('products', $input);
        $this->assertEquals('skuproduct453', $newProduct->sku);
    }

    /** @test */
    public function it_will_edit_an_existing_product(){
        //given
        $products = factory(Product::class, 4)->create();
        //and updated the second product
        $input = [
            'id' => $products[1]->id,
            'sku' => 'changedsku',
            'colour' => 'changedcolour'
        ];

        //when
        $updated = $this->productRepo->editProduct($input);

        //$this->assertTrue($updated);
        $this->seeInDatabase('products', $input);
    }
}
