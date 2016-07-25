<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use \Mockery;
use MiniErp\Repositories\OrderRepository;
use MiniErp\Repositories\ItemRepository;
use MiniErp\OrderProcessing\OrderProcessor;
use MiniErp\OrderProcessing\UpdateOrGenerateOrderItems;

class OrderProcessorTest extends TestCase
{
	private $orderProcessor;

	private $orderRepo;

	private $updateOrGenerateOrderItems;

	public function setUp(){

		$this->orderRepo = Mockery::mock(OrderRepository::class);
        $this->updateOrGenerateOrderItems = Mockery::mock(UpdateOrGenerateOrderItems::class);
		$this->orderProcessor = new OrderProcessor($this->orderRepo, $this->updateOrGenerateOrderItems);

	}

    /** @test */
    public function it_will_create_a_new_order()
    {
    	$input = [
    		'order' => [
    			'customer_name' => 'Gabriel Jaramillo',
    			'address' => 'test_address',
    			'total' => 100,
    			'items' => [
    				['sku' => 'testsku1', 'quantity' => 2],
    				['sku' => 'testsku2', 'quantity' => 1]
    			] 
    		]
    	];

        $newOrder = Mockery::mock('MiniErp\Entities\Order');
        $newOrder->shouldReceive('getAttribute')->with('id');

        //extract the order info from the input 
        $orderArray = array_slice($input['order'], 0, 2);
        //and add the status value to this order
        $orderArray['status'] = 'In progress';

        //take the customer_name, address
    	$this->orderRepo->shouldReceive('makeOrder')
            ->once()
            ->with($orderArray)
            ->andReturn($newOrder);

        //extract the items from the order
        $orderItems = $input['order']['items'];

    	$this->updateOrGenerateOrderItems->shouldReceive('updateOrGenerateOrderItems')
            ->once()
            ->with($newOrder->id, $orderItems);

    	$this->orderProcessor->processOrder($input);

    }
}
