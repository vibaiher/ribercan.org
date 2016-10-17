<?php

namespace Ribercan\HowToHelpBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class StaticPagesControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $client->request('GET', '/how-to-help');
        $crawler = $client->followRedirect();

        $this->assertContains('Como ayudar', $client->getResponse()->getContent());

        $pages = array(
            'Adopta', 'Acoge', 'Hazte socio', 'Apadrina', 'Hazte voluntario',
            'Dona material', 'Haz un donativo', 'Grupo teaming'
        );

        foreach ($pages as $title)
        {
            $link = $crawler
                ->filter("a:contains('$title')")
                ->link();

            $crawler = $client->click($link);

            $this->assertCount(
                1,
                $crawler->filter("h1:contains('$title')"),
                "We are on $title page"
            );
        }
    }
}
