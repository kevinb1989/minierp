<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Event;
use App\Events\ProductsAreCreatedForOrder;

use MiniErp\OrderProcessing\OrderProcessor;
use MiniErp\OrderRequestDecoding\OrderRequestDecoder;
use MiniErp\Repositories\OrderRepository;


class OrdersController extends Controller
{

	private $orderProcessor;

    private $orderRepo;

	public function __construct(OrderRepository $orderRepo, OrderProcessor $orderProcessor){
        $this->orderRepo = $orderRepo;
		$this->orderProcessor = $orderProcessor;
	}

    /**
     * Display a listing of the orders.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = $this->orderRepo->getAllOrders();

        return view('orders.index', compact('orders'));
    }

    /**
     * Store a newly created order and update its items in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = OrderRequestDecoder::decode($request->getContent());

        $newProductsCreated = $this->orderProcessor->processOrder($input);

        //in case new products are created to match this order
        //a event will be fired to send a notification email to the admin
        if($newProductsCreated){
            Event::fire(new ProductsAreCreatedForOrder());
        }

        return 'Order saved';
    }

    /**
     * Show the form for editing the specified order.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = $this->orderRepo->getOrder($id);

        return view('orders.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
