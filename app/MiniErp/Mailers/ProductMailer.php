<?php
namespace MiniErp\Mailers;

use MiniErp\Entities\User;

/**
 * This class sends a notification email to
 * the system admin saying that new products
 * have been created to match an order. At this
 * stage, the email is simply logged in laravel.log
 *
 * @package MiniErp\Mailers
 * @category Mailer
 * @author Kevin Bui
 * @version 0.5
 */
class ProductMailer extends Mailer{
	
	/**
	 * Send a notification email to the
	 * system admin when products are created to match
	 * an order
	 * 
	 * @param  MiniErp\Entities $user the system admin
	 * @return void
	 */
	public function sendNotificationTo($user){
		$subject = 'A new product has been generated';
		$view = 'emails.mail-to-admin';
		$data = [];

		$this->sendTo($user, $subject, $view);
	}
}