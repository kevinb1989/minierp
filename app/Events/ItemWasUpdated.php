<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use MiniErp\Entities\Order;

/**
 * This event will be generated when
 * An item is set to "Delivered"
 * in order to update the order status
 *
 * @category Events
 * @package App\Events
 * @author Kevin Bui
 * @version 0.5
 */
class ItemWasUpdated extends Event
{
    use SerializesModels;

    public $order;

    /**
     * Create a new event instance.
     *
     * @param MiniErp\Entities\Order $order
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
