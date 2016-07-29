<?php

namespace App\Listeners;

use App\Events\ProductsAreCreatedForOrder;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use MiniErp\Mailers\ProductMailer;
use MiniErp\Entities\User;


/**
 * This class will send an email to the admin,
 * informing that new products have been created
 * to matched an order. At this stage, the email will be logged
 *
 * @package App\Listeners
 * @category Listener
 * @author Kevin Bui
 * @version 0.5
 */
class ProductsAreCreatedForOrderListener
{
    private $productMailer;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(ProductMailer $productMailer)
    {
        $this->productMailer = $productMailer;
    }

    /**
     * Handle the event.
     *
     * @param  ProductsAreCreatedForOrder  $event
     * @return void
     */
    public function handle(ProductsAreCreatedForOrder $event)
    {
        //at this stage, we just create a fake admin
        $user = factory(User::class)->make([
            'name' => 'system admin',
            'email' => 'admin@brosa.com.au'
        ]);

        $this->productMailer->sendNotificationTo($user);
    }
}
