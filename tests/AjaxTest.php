<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AjaxTest extends WebTestCase
{
    public function testAjaxGetCities(): void
    {
        $client = static::createClient(server:['HTTP_HOST'=>'localhost:8000']);
        $crawler = $client->xmlHttpRequest('GET', '/ajax/cities/paris 7501', [], []);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('Content-Type', 'application/json');

        $expectedCities = [
            (object) [
                'id' => 29909,
                'name' => 'Paris',
                'zip_code' => '75010',
                'insee_code' => '75056',
                'slug' => 'paris'
            ],
            (object) [
                'id' => 29910,
                'name' => 'Paris',
                'zip_code' => '75011',
                'insee_code' => '75056',
                'slug' => 'paris'
            ],
            (object) [
                'id' => 29911,
                'name' => 'Paris',
                'zip_code' => '75012',
                'insee_code' => '75056',
                'slug' => 'paris'
            ],
            (object) [
                'id' => 29912,
                'name' => 'Paris',
                'zip_code' => '75013',
                'insee_code' => '75056',
                'slug' => 'paris'
            ],
            (object) [
                'id' => 29913,
                'name' => 'Paris',
                'zip_code' => '75014',
                'insee_code' => '75056',
                'slug' => 'paris'
            ],
            (object) [
                'id' => 29914,
                'name' => 'Paris',
                'zip_code' => '75015',
                'insee_code' => '75056',
                'slug' => 'paris'
            ],
            (object) [
                'id' => 29915,
                'name' => 'Paris',
                'zip_code' => '75016',
                'insee_code' => '75056',
                'slug' => 'paris'
            ],
            (object) [
                'id' => 29916,
                'name' => 'Paris',
                'zip_code' => '75017',
                'insee_code' => '75056',
                'slug' => 'paris'
            ],
            (object) [
                'id' => 29917,
                'name' => 'Paris',
                'zip_code' => '75018',
                'insee_code' => '75056',
                'slug' => 'paris'
            ],
            (object) [
                'id' => 29918,
                'name' => 'Paris',
                'zip_code' => '75019',
                'insee_code' => '75056',
                'slug' => 'paris'
            ]
        ];
        $responseContent = json_decode($client->getResponse()->getContent());
        $this->assertEquals($expectedCities, $responseContent);
        // fwrite(STDERR, print_r([$responseContent, $expectedCities], TRUE));        
    }
}
