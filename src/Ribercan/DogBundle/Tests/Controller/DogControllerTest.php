<?php

namespace Ribercan\DogBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DogControllerTest extends WebTestCase
{
    public function testDogsPage()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/dogs');

        $this->assertTrue($crawler->filter('html:contains("Dogs waiting for adoption")')->count() > 0);
    }
}
