<?php

namespace App\Listeners;

use App\Events\ItemWasUpdated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use MiniErp\Repositories\OrderRepository;

/**
 * This class will set an order's status 
 * to "Completed" if all of its items are delivered
 *
 * @category Listeners
 * @package App\Listeners
 * @author Kevin Bui
 * @version 0.5
 */
class UpdateOrderStatus
{
    private $orderRepo;

    /**
     * Create the event listener.
     *
     * @param MiniErp\Repositories\OrderRepository $orderRepo
     * @return void
     */
    public function __construct(OrderRepository $orderRepo)
    {
        $this->orderRepo = $orderRepo;
    }

    /**
     * Handle the event.
     *
     * @param  App\Events\ItemWasUpdated  $event
     * @return void
     */
    public function handle(ItemWasUpdated $event)
    {
        $this->orderRepo->complete($event->order);
    }
}
