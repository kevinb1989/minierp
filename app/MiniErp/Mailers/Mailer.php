<?php
namespace MiniErp\Mailers;

use Illuminate\Mail\Mailer as Mail;

/**
 * This abstract class send an email to a specific
 * user.
 *
 * @category Mailers
 * @package MiniErp\Mailers
 * @author Kevin Bui
 * @version 0.5
 */
abstract class Mailer{

	private $mailer;

	public function __construct(Mail $mailer){
		$this->mailer = $mailer;
	}
	
	/**
	 * Sen an email to the user
	 * 
	 * @param  MiniErp\Entities\User $user
	 * @param  string $subject the subject of the email
	 * @param  string $view    The php file to display email content
	 * @param  array  $data    
	 * @return void
	 */
	public function sendTo($user, $subject, $view, $data = []){
		$this->mailer->queue($view, $data, function($message) use($user, $subject){
			$message->to($user->email)->subject($subject);
		});
	}
}