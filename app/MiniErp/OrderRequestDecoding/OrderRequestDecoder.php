<?php
namespace MiniErp\OrderRequestDecoding;

/**
 * This class will transfer the body of a json request
 * (order request) to an array
 *
 * @category OrderRequestDecoding
 * @package MiniErp\OrderRequestDecoding
 * @author Kevin Bui
 * @version 0.5
 */
class OrderRequestDecoder{

	/**
	 * Transform the body of a json request to an array
	 * 
	 * @param  string $orderRequest the body of a json request
	 * @return array
	 */
	public static function decode($orderRequest){
		return json_decode($orderRequest, true);
	}
}
