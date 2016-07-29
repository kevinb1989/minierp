<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Events\ItemWasUpdated;

use MiniErp\Repositories\ItemRepository;
use MiniErp\Repositories\ProductRepository;
use MiniErp\Constants\ItemPhysicalStatus;

use Event;

class ItemsController extends Controller
{
    private $itemRepo;

    private $productRepo;

    public function __construct(ItemRepository $itemRepo, ProductRepository $productRepo){
        $this->itemRepo = $itemRepo;
        $this->productRepo = $productRepo;
    }

    /**
     * Display a listing of all items.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = $this->itemRepo->getAllItems();

        return view('items.index', compact('items'));
    }

    /**
     * Show the form for creating a new item.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = $this->productRepo->getAllProductNames();

        return view('items.create', compact('products'));
    }

    /**
     * Store a newly created item in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newItem = $this->itemRepo->addItem($request->all());

        flash('A new item has been created.');

        return Redirect('items');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = $this->itemRepo->getItemById($id);

        //if the item's physical status is "Delivered",
        //its info cannot be changed. So we redirect to the order page
        if($item->physical_status == ItemPhysicalStatus::Delivered){
            flash('That item cannot be edited because it has been delivered.', 'alert-warning');
            return Redirect('items');
        }

        //get a list of all products to display in selection box
        $products = $this->productRepo->getAllProductNames();

        return view('items.edit', compact('item', 'products'));
    }

    /**
     * Update the specified item in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->only('product_id', 'status', 'physical_status');
        $input['id'] =$id;
        $updated = $this->itemRepo->editItem($input);

        //in case the item's physical status is changed to "Delivered",
        //an event is fired to attempt changing the order to "Completed"
        if($input['physical_status'] == ItemPhysicalStatus::Delivered){
            //retrieve the order of this item
            $order = $this->itemRepo->getOrderFromItem($id);
            if(!is_null($order)) Event::fire(new ItemWasUpdated($order));
        }

        flash('The item has been updated. If it is set to delivered, its order may have been completed.');

        return Redirect('items');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
