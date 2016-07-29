<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use MiniErp\OrderRequestDecoding\OrderRequestDecoder;

class OrderRequestDecoderTest extends TestCase
{
    /** @test */
    public function it_will_transform_a_json_request_to_an_array()
    {
        //given
        //an order request in json type
        $jsonRequest= "{\"order\": {
            \"customer_name\":\"Gabriel Jaramillo\",
            \"address\":\"test_address\",
            \"total\":100,
            \"items\":[
            {\"sku\":\"testsku1\", \"quantity\":2},
            {\"sku\":\"testsku2\",\"quantity\":1}]}}";
            
        $itemsArray = [
        	['sku' => 'testsku1', 'quantity' => 2],
        	['sku' => 'testsku2', 'quantity' => 1]
        ];

        //when
        $orderRequest = OrderRequestDecoder::decode($jsonRequest);

        //then
        
        $this->assertEquals('Gabriel Jaramillo', $orderRequest['order']['customer_name']);
        $this->assertEquals('test_address', $orderRequest['order']['address']);
        $this->assertEquals($itemsArray, $orderRequest['order']['items']);
    }
}
