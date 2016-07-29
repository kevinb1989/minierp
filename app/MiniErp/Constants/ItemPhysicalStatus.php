<?php
namespace MiniErp\Constants;

/**
 * This class list all possible physical status
 * of an item. These are 'To order', 'In warehouse',
 * and 'Delivered'
 *
 * @package MiniErp\Constants
 * @category Contants
 * @author Kevin Bui
 * @version 0.5
 */
class ItemPhysicalStatus extends MyEnum{
	const __default = self::InWarehouse;
	
	const ToOrder = 'To order';
	const InWarehouse = 'In warehouse';
	const Delivered = 'Delivered';
}