<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use MailThief\Facades\MailThief;
use MiniErp\Entities\User;
use MiniErp\Mailers\ProductMailer;

class GenerateEmailForNewProductTest extends TestCase
{
	use DatabaseTransactions;
    /** @test */
    public function it_will_send_an_email_to_admin_when_a_new_product_is_created_to_order()
    {
        $user = factory(User::class)->make();

        $mailer = new ProductMailer(app('Illuminate\Mail\Mailer'));

        $mailer->sendNotificationTo($user);

        MailThief::hijack();

        //check that an email is sent to this email address
        $this->assertFalse(MailThief::hasMessageFor($user->email));
    }
}
