<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use \Mockery;
use MiniErp\Repositories\OrderRepository;

class OrderRepositoryTest extends TestCase
{

    private $orders;

    private $orderRepo;

    /** @var Illuminate\Database\Eloquent\Builder the object will be returned anytime the where function is called */
    private $builder;

    public function setUp(){
    	parent::setUp();

    	$this->builder = Mockery::mock('Illuminate\Database\Eloquent\Builder');
        $this->orders = Mockery::mock('MiniErp\Entities\Order');
    	$this->orderRepo = new OrderRepository($this->orders);
    }

    /** @test */
    public function it_will_return_a_list_of_all_orders()
    {
    	

        $this->orders->shouldReceive('with')
        	->once()
        	->andReturn($this->builder);

        $this->builder->shouldReceive('get')->once();

        $orderList = $this->orderRepo->getAllOrders();
    }

    /** @test */
    public function it_will_return_a_specific_order(){
        $orderId = 2;
        $order = Mockery::mock('MiniErp\Entities\Order');

        $this->orders->shouldReceive('with')
            ->once()
            ->with('items')
            ->andReturn($this->builder);

        $this->builder->shouldReceive('find')
            ->once()
            ->with($orderId);

        $orderList = $this->orderRepo->getOrder($orderId);
    }

    /** @test */
    public function it_will_change_the_status_of_the_order(){
        $input = [
            'id' => 1,
            'status' => 'Completed'
        ];

        $this->orders->shouldReceive('where')
            ->once()
            ->with('id', $input['id'])
            ->andReturn($this->builder);

        $this->builder->shouldReceive('update')->once();

        $this->orderRepo->changeStatus($input);
    }

    /** @test */
    public function it_will_create_an_order_record_in_the_order_table(){
        $input = [
            'customer_name' => 'Kevin Bui',
            'address' => '3A/1 Victoria Place, Richmond 3121',
            'status' => 'In progress',
        ];

        $this->orders->shouldReceive('create')->once();

        $this->orderRepo->makeOrder($input);
    }
}
