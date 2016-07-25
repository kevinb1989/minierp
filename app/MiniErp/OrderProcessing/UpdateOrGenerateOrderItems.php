<?php
namespace MiniErp\OrderProcessing;
use MiniErp\Repositories\ItemRepository;
use MiniErp\Repositories\ProductRepository;
use MiniErp\Entities\Item;
use MiniErp\Entities\Product;

/**
 * The UpdateOrGenerateOrderItems class update or generate items
 * for a freshly created order
 *
 * This class takes into account the order id and a list of order items.
 * It will attached matched existing available items to the order.
 * It may create new items to matched the ordered list.
 * If even the product doesn't exist, this class is gonna create the product,
 * and the generate the items.
 *
 * @category OrderProcessing
 * @package MiniErp\OrderProcessing
 * @author Kevin Bui
 * @version 0.1
 * 
 */
class UpdateOrGenerateOrderItems{
	
	private $itemRepo;

	private $productRepo;

	public function __construct(ItemRepository $itemRepo, ProductRepository $productRepo){
		$this->itemRepo = $itemRepo;
		$this->productRepo = $productRepo;
	}

	/**
	 * Update or generate all order items
	 *  
	 * @param  int $newOrderId the id of the freshly created order
	 * @param  array $orderItems the array of demanded items in the new order
	 */
	public function updateOrGenerateOrderItems($newOrderId, $orderItems){
		$allItems = $this->itemRepo->getAllItems();

		//take the first item from the order
		while($orderItem = array_shift($orderItems)){

			//retrieve the collection that match the item
			$matchedItems = $allItems->filter(function($item, $key) use ($orderItem, $newOrderId){
				return $item->status == "Available" && $item->product->sku == $orderItem['sku'];
			});

			//in case there are just enough matched items in the database,
			//all these items will be updated to the order
			if($matchedItems->count() == $orderItem['quantity']){
				$this->updateAllMatchedItems($matchedItems, $newOrderId);

			}
			//in case there are more than enough matched items in the database,
			//only the required number of items will be updated to the order
			//the rest will remained availabe
			elseif($matchedItems->count()>$orderItem['quantity']){
				//redundant items will be cut
				$matchedItems = $matchedItems->slice(0, $orderItem['quantity']);
				$this->updateAllMatchedItems($matchedItems, $newOrderId);

			}
			//in case there are less than enough matched available items in the database,
			//all these items will be updated to the order
			//extra records will be generated to match the order.
			elseif($matchedItems->count()<$orderItem['quantity'] && $matchedItems->count()>0){
				//firstly, all the matched items will be updated
				$this->updateAllMatchedItems($matchedItems, $newOrderId);
				//number of missing items
				$missingCount = $orderItem['quantity'] - $matchedItems->count();
				//retrieve the product_id
				$productId = $matchedItems->first()->product_id;

				$this->generateNewOrderItems($productId, $newOrderId, $missingCount);
			}
			//in case there's no available item at all
			elseif($matchedItems->count() == 0){
				//retrieve the product by sku
				$product = $this->productRepo->findProductBySku($orderItem{'sku'});
				//In case the product with the sku exists, new items will be generated for the order
				if(!is_null($product)){
					$this->generateNewOrderItems($product->id, $newOrderId, $orderItem['quantity']);
				}
				//In case the product with the sku does not exists
				else{
					//firstly, a product with the sku will be created
					$product = $this->productRepo->addProduct([
						'sku' => $orderItem['sku'],
						'colour' => 'green' 
					]);
					//Then new items of this product will be generated for the order
					$this->generateNewOrderItems($product->id, $newOrderId, $orderItem['quantity']);	
				}
				
			}
		}

		return $matchedItems->count();
	}


	/**
	 * Update all matched items to "Assigned" and attach it to a specified order
	 * 
	 * @param  Illuminate\Database\Eloquent\Collection $matchedItems
	 * @param  int $newOrderId
	 * @return Illuminate\Database\Eloquent\Collection
	 */
	private function updateAllMatchedItems($matchedItems, $newOrderId){
		return $matchedItems->each(function($item, $key) use ($newOrderId){
				$item->order_id = $newOrderId;
				$item->status = 'Assigned';
				$item->save();
		});
	}

	/**
	 * Add more items to the items table to fulfill the order
	 * 
	 * @param  int $productId
	 * @param  int $newOrderId
	 * * @param  int $missingCount
	 */
	private function generateNewOrderItems($productId, $newOrderId, $missingCount){
		//adding numerous identical missing item to an array
			$newItems = [];
			while(count($newItems) < $missingCount){
				$newItems[] = [
					'product_id' => $productId,
					'order_id' => $newOrderId,
					'status' => 'Assigned',
					'physical_status' => 'To order'
				];
			}

			Item::insert($newItems);
	}
}