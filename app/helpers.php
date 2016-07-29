<?php

/**
 * flash a notification message after an user's action
 * 
 * @param  string $message
 * @param  string $type The CSS class to display this message
 * @return void
 */
function flash($message, $type = 'alert-success'){
	session()->flash('flash_message', $message);
	session()->flash('flash_message_type', $type);
}