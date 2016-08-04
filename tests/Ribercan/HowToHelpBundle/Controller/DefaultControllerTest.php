<?php

namespace Ribercan\HowToHelpBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/how-to-help');

        $this->assertContains('Adopta', $client->getResponse()->getContent());
    }
}
