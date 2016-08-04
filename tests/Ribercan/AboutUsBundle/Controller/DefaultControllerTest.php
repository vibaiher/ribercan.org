<?php

namespace Ribercan\AboutUsBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/about-us');

        $this->assertContains('Quiénes somos', $client->getResponse()->getContent());
    }
}
