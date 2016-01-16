<?php

namespace Ribercan\DogBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DogControllerTest extends WebTestCase
{
    /**
     * @test
     */
    public function dogsPageExists()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/dogs');

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /dogs/");
    }
}
