<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AjaxTest extends WebTestCase
{
    public function testAjaxGetCities(): void
    {
        $client = static::createClient(server:['HTTP_HOST'=>'localhost:8000']);
        $client->xmlHttpRequest('GET', '/ajax/cities/paris 7501', [], []);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('Content-Type', 'application/json');

        $expectedCities = [
            (object) [
                'id' => 29909,
                'name' => 'Paris',
                'zip_code' => 75010,
                'latitude' => 48.8785618,
                'longitude' => 2.3603689,
                'insee_code' => '75056',
                'slug' => 'paris'
            ],
            (object) [
                'id' => 29910,
                'name' => 'Paris',
                'zip_code' => 75011,
                'latitude' => 48.85799300000001,
                'longitude' => 2.381153,
                'insee_code' => '75056',
                'slug' => 'paris'
            ],
            (object) [
                'id' => 29911,
                'name' => 'Paris',
                'zip_code' => 75012,
                'latitude' => 48.8293647,
                'longitude' => 2.4265406,
                'insee_code' => '75056',
                'slug' => 'paris'
            ],
            (object) [
                'id' => 29912,
                'name' => 'Paris',
                'zip_code' => 75013,
                'latitude' => 48.830759,
                'longitude' => 2.359204,
                'insee_code' => '75056',
                'slug' => 'paris'
            ],
            (object) [
                'id' => 29913,
                'name' => 'Paris',
                'zip_code' => 75014,
                'latitude' => 48.8314408,
                'longitude' => 2.3255684,
                'insee_code' => '75056',
                'slug' => 'paris'
            ],
            (object) [
                'id' => 29914,
                'name' => 'Paris',
                'zip_code' => 75015,
                'latitude' => 48.8421616,
                'longitude' => 2.2927665,
                'insee_code' => '75056',
                'slug' => 'paris'
            ],
            (object) [
                'id' => 29915,
                'name' => 'Paris',
                'zip_code' => 75016,
                'latitude' => 48.8530933,
                'longitude' => 2.2487626,
                'insee_code' => '75056',
                'slug' => 'paris'
            ],
            (object) [
                'id' => 29916,
                'name' => 'Paris',
                'zip_code' => 75017,
                'latitude' => 48.891986,
                'longitude' => 2.319287,
                'insee_code' => '75056',
                'slug' => 'paris'
            ],
            (object) [
                'id' => 29917,
                'name' => 'Paris',
                'zip_code' => 75018,
                'latitude' => 48.891305,
                'longitude' => 2.3529867,
                'insee_code' => '75056',
                'slug' => 'paris'
            ],
            (object) [
                'id' => 29918,
                'name' => 'Paris',
                'zip_code' => 75019,
                'latitude' => 48.89061359999999,
                'longitude' => 2.3867083,
                'insee_code' => '75056',
                'slug' => 'paris'
            ]
        ];
        $responseContent = json_decode($client->getResponse()->getContent());
        $this->assertEquals($expectedCities, $responseContent);
        // fwrite(STDERR, print_r([$responseContent, $expectedCities], TRUE));        
    }
}
