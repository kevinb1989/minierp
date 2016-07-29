<?php
namespace MiniErp\Constants;

/**
 * This class list all possible status
 * of an order. These are 'In progress',
 * 'Completed' and 'Cancelled'
 *
 * @package MiniErp\Constants
 * @category Contants
 * @author Kevin Bui
 * @version 0.5
 */
class OrderStatus extends MyEnum{
	const __default = self::InProgress;
	
	const InProgress = 'In progress';
	const Completed = 'Completed';
	const Cancelled = 'Cancelled';

}