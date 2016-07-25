<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use MiniErp\Repositories\ItemRepository;
use \Mockery;

class ItemRepositoryTest extends TestCase
{
	private $items;
	private $itemRepo;

	public function setUp(){
		parent::setUp();

		$this->items = Mockery::mock('MiniErp\Entities\Item');
		$this->itemRepo = new ItemRepository($this->items);
	}

    /** @test */
    public function it_will_return_a_list_of_all_items()
    {
    	$builder = Mockery::mock('Illuminate\Database\Eloquent\Builder');

    	$this->items->shouldReceive('with')
    		->once()
    		->andReturn($builder);

    	$builder->shouldReceive('get')->once();

    	$itemList = $this->itemRepo->getAllItems();
    }

    /** @test */
    public function it_will_create_a_new_item(){
    	$input = [
    		'product_id' => 1,
    		'status' => 'Assigned',
    		'physical_status' => 'in warehouse'
    	];

    	$this->items->shouldReceive('create')
    		->once()
    		->with($input);

    	$itemList = $this->itemRepo->addItem($input);
    }

    /** @test */
    public function it_will_update_an_existing_item(){
    	$input = [
    		'id' => 1,
    		'product_id' => 1,
    		'status' => 'Assigned',
    		'physical_status' => 'in warehouse'
    	];

    	$builder = Mockery::mock('Illuminate\Database\Eloquent\Builder');

    	$this->items->shouldReceive('where')
    		->once()
    		->with('id', $input['id'])
    		->andReturn($builder);

    	$builder->shouldReceive('update')
    		->once()
    		->with($input);

    	$itemList = $this->itemRepo->editItem($input);
    }
}
