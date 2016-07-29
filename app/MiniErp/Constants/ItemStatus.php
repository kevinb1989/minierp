<?php
namespace MiniErp\Constants;

/**
 * This class list all possible status
 * of an item. These are 'Available'
 * and 'Assigned'
 *
 * @package MiniErp\Constants
 * @category Contants
 * @author Kevin Bui
 * @version 0.5
 */
class ItemStatus extends MyEnum{
	const __default = self::Available;
	
	const Available = 'Available';
	const Assigned = 'Assigned';
	

}