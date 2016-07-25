<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use MiniErp\Entities\Product;
use MiniErp\Entities\Item;
use MiniErp\Entities\Order;
use MiniErp\Repositories\OrderRepository;

class OrderRepositoryTest extends TestCase
{   
	use DatabaseTransactions;

	private $orderRepo;

	public function setUp(){
		parent::setUp();
		$this->orderRepo = new OrderRepository(new Order);
	}

	/** @test */
    public function it_will_return_a_list_of_all_orders()
    {
        //given
        $products = factory(Product::class)->create();
        $orders = factory(Order::class, 2)->create();
        $items = factory(Item::class, 2)->create([
        	'order_id' => $orders[0]->id
        ]);
        $item = factory(Item::class)->create([
        	'order_id' => $orders[1]->id
        ]);

        //when
        $orderList = $this->orderRepo->getAllOrders();

        //then
        $this->assertEquals(2, $orderList->count());
        $this->assertEquals(2, $orderList[0]->items->count());
        $this->assertEquals($items[0]->status, $orderList[0]->items[0]->status);
    }

    /** @test */
    public function it_will_return_a_specific_order(){
    	//given
        $product = factory(Product::class)->create();
        $orders = factory(Order::class, 2)->create();
        $items = factory(Item::class, 2)->create([
        	'order_id' => $orders[0]->id
        ]);
        $item = factory(Item::class)->create([
        	'order_id' => $orders[1]->id
        ]);

        //when
        $order = $this->orderRepo->getOrder($orders[0]->id);

        //then
        $this->assertEquals($orders[0]->customer_name, $order->customer_name);
        $this->assertCount(2, $order->items);
    }

    /** @test */
    public function it_will_change_the_status_of_an_order(){
		//given
        $product = factory(Product::class)->create();
        $orders = factory(Order::class, 2)->create([
        	'status' => 'In progress'
        ]);
        $items = factory(Item::class, 2)->create([
        	'order_id' => $orders[0]->id
        ]);
        $item = factory(Item::class)->create([
        	'order_id' => $orders[1]->id
        ]);

        $input = [
        	'id' => $orders[0]->id,
        	'status' => 'Completed'
        ];

        //when
        $count = $this->orderRepo->changeStatus($input);

        //then
        $this->seeInDatabase('orders', $input);
    }

    /** @test */
    public function it_will_create_an_order_record_in_the_database(){
        //given
        $input = [
            'customer_name' => 'Kevin Bui',
            'address' => '302/1 Queens Avenue, Hawthorn 3122',
            'status' => 'In progress'
        ];

        //when
        $newOrder = $this->orderRepo->makeOrder($input);

        $this->seeInDatabase('orders', $input);
        $this->assertEquals($input['customer_name'], $newOrder->customer_name);
    }
}
