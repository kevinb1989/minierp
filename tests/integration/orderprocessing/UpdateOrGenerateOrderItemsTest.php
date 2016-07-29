<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use MiniErp\Entities\Product;
use MiniErp\Entities\Item;
use MiniErp\Entities\Order;
use MiniErp\Repositories\ItemRepository;
use MiniErp\Repositories\ProductRepository;
use MiniErp\OrderProcessing\OrderProcessor;
use MiniErp\OrderProcessing\UpdateOrGenerateOrderItems;

class UpdateOrGenerateOrderItemsTest extends TestCase
{
	use DatabaseTransactions;

	private $updateOrGenerateOrderItems;

	public function setUp(){
    parent::setUp();

		$this->updateOrGenerateOrderItems = new UpdateOrGenerateOrderItems(
            new ItemRepository(new Item),
            new ProductRepository(new Product));
	}

	  /** @test */
    public function it_will_generate_items_for_an_order_when_there_are_just_enough_available_items()
    {
        //given
        $product = factory(Product::class)->create([
          'sku' => 'productsku01'
        ]);

        $items = factory(Item::class, 3)->create([
          'product_id' => $product->id
        ]);

        $order = factory(Order::class)->create();
        
       	$items = [
          ['sku' => 'productsku01', 'quantity' => 3]
        ];

        //when
        $newProductsCreated = $this->updateOrGenerateOrderItems->updateOrGenerateOrderItems($order->id, $items);

        //then
       	$this->assertEquals(3, Order::find($order->id)->items()->get()->count());
        $this->assertFalse($newProductsCreated);
    }

    /** @test */
    public function it_will_generate_items_for_an_order_when_there_are_more_than_enough_available_items()
    {
        //given
        $product = factory(Product::class)->create([
          'sku' => 'productsku01'
        ]);

        $items = factory(Item::class, 5)->create([
          'product_id' => $product->id
        ]);

        $order = factory(Order::class)->create();
        
        $items = [
          ['sku' => 'productsku01', 'quantity' => 2]
        ];

        //when
        $newProductsCreated =  $this->updateOrGenerateOrderItems->updateOrGenerateOrderItems($order->id, $items);

        //then
        $this->assertEquals(2, Order::find($order->id)->items()->get()->count());
        $this->assertEquals(3, Item::where('status','Available')->get()->count());
        $this->assertFalse($newProductsCreated);
    }

    /** @test */
    public function it_will_generate_items_for_an_order_when_there_are_less_than_enough_available_items(){
        //given
        $product = factory(Product::class)->create([
          'sku' => 'productsku01'
        ]);

        $items = factory(Item::class, 3)->create([
          'product_id' => $product->id
        ]);

        $order = factory(Order::class)->create();
        
        $items = [
          ['sku' => 'productsku01', 'quantity' => 7]
        ];

        //when
        $newProductsCreated = $this->updateOrGenerateOrderItems->updateOrGenerateOrderItems($order->id, $items);

        //then
        $this->assertEquals(7, Order::find($order->id)->items()->get()->count());
        $this->assertFalse($newProductsCreated);
    }

    /** @test */
    public function it_will_generate_items_for_an_order_when_there_are_no_available_items_at_all_and_the_product_exists(){
        //given
        $product = factory(Product::class)->create([
          'sku' => 'productsku01'
        ]);

        $order = factory(Order::class)->create();
        
        $items = [
          ['sku' => 'productsku01', 'quantity' => 4]
        ];

        //when
        $newProductsCreated = $this->updateOrGenerateOrderItems->updateOrGenerateOrderItems($order->id, $items);

        //then
        $this->assertEquals(4, Order::find($order->id)->items()->get()->count());
        $this->assertEquals(4, Item::where(['order_id' => $order->id, 'product_id' => $product->id, 'status' => 'Assigned'])->get()->count());
        $this->assertFalse($newProductsCreated);
    }

    /** @test */
    public function it_will_generate_items_for_an_order_when_there_are_no_available_items_at_all_and_the_product_does_not_exists(){
        //given
        $order = factory(Order::class)->create();
        
        $items = [
          ['sku' => 'productsku01', 'quantity' => 4]
        ];

        //when
        $newProductsCreated = $this->updateOrGenerateOrderItems->updateOrGenerateOrderItems($order->id, $items);

        //then
        $this->assertEquals(4, Order::find($order->id)->items()->get()->count());
        $this->assertEquals(4, Item::where(['order_id' => $order->id, 'status' => 'Assigned'])->get()->count());
        $this->assertTrue($newProductsCreated);
    }

    /** @test */
    public function now_lets_try_this_with_multiple_items_with_large_quantity(){
        //given
        $order = factory(Order::class)->create();
        
        $items = [
          ['sku' => 'productsku01', 'quantity' => 4],
          ['sku' => 'productsku02', 'quantity' => 5]
        ];

        //when
        $newProductsCreated = $this->updateOrGenerateOrderItems->updateOrGenerateOrderItems($order->id, $items);

        //then
        $this->assertEquals(9, Order::find($order->id)->items()->get()->count());
        $this->assertEquals(9, Item::where(['order_id' => $order->id, 'status' => 'Assigned'])->get()->count());
        $this->assertTrue($newProductsCreated);
    }
}
