<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use MiniErp\Repositories\ItemRepository;
use MiniErp\Entities\Item;
use MiniErp\Entities\Order;
use MiniErp\Entities\Product;

class ItemRepositoryTest extends TestCase
{
    
	use DatabaseTransactions;

	private $itemRepo;

	public function setUp(){
		parent::setUp();

		$this->itemRepo = new ItemRepository(new Item);
	}

	/** @test */
    public function it_will_return_a_list_of_all_items()
    {
        //given
        factory(Product::class, 3)->create();
        factory(Item::class, 5)->create();

        //when
        $factories = $this->itemRepo->getAllItems();

        //then
        $this->assertEquals(5, $factories->count());
    }

    /** @test */
    public function it_will_create_a_new_item(){
        //given
        $product = factory(Product::class)->create();

        $input = [
            'product_id' => $product->id,
            'status' => 'Available',
            'physical_status' => 'In warehouse'
        ];

        //when
        $newItem = $this->itemRepo->addItem($input);

        //then
        $this->seeInDatabase('items', $input);
        $this->assertEquals($input['product_id'], $newItem->product_id);
    }

    /** @test */
    public function it_will_edit_an_existing_item(){
        //given
        $product = factory(Product::class)->create();
        $item = factory(Item::class)->create([
            'product_id' => $product->id
        ]);

        $input = [
            'id' => $item->id,
            'status' => 'Assigned',
            'physical_status' => 'Delivered'
        ];

        //when
        $count = $this->itemRepo->editItem($input);

        //then
        $this->seeInDatabase('items', $input);
        $this->assertEquals(1, $count);
    }

    /** @test */
    public function it_will_return_the_order_that_owns_a_specific_item(){
        //given
        $product = factory(Product::class)->create();
        $order = factory(Order::class)->create();
        $item = factory(Item::class)->create([
            'order_id' => $order->id,
            'product_id' => $product->id
        ]);
        
        $order = $this->itemRepo->getOrderFromItem($item->id);

        
    }
}
