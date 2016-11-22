<?php

namespace Tests\Ribercan\AdvicesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class StaticPagesControllerTest extends WebTestCase
{
    /**
     * @test
     */
    public function advicesAreAccessible()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/advices');

        $this->assertContains('Consejos', $client->getResponse()->getContent());

        $pages = array(
            'Ponme el chip', 'Guia del adoptante', 'Leishmania',
            'Perros y niños', 'Perros y gatos', 'Que hacer si te encuentras un perro',
            'El golpe de calor', 'Mi mascota se ha perdido'
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
