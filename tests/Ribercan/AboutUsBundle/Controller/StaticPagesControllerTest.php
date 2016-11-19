<?php

namespace Tests\Ribercan\AboutUsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class StaticPagesControllerTest extends WebTestCase
{
    /**
     * @test
     */
    public function aboutUsHasAMenuWithAllTheAboutUsEntries()
    {
        $client = static::createClient();

        $client->request('GET', '/about-us');
        $crawler = $client->followRedirect();

        $this->assertContains('Quiénes somos', $client->getResponse()->getContent());

        $contact_link = $crawler
            ->filter('a:contains("Contactos")')
            ->link();

        $crawler = $client->click($contact_link);

        $this->assertCount(
            1,
            $crawler->filter("h1:contains('Contactos')"),
            'We are on Contactos page'
        );

        $for_regina_link = $crawler
            ->filter('a:contains("Por Regina")')
            ->link();

        $crawler = $client->click($for_regina_link);

        $this->assertCount(
            1,
            $crawler->filter("h1:contains('Por Regina')"),
            'We are on Por Regina page'
        );

        $ribercan_friends_link = $crawler
            ->filter('a:contains("Amigos Ribercan")')
            ->link();

        $crawler = $client->click($ribercan_friends_link);

        $this->assertCount(
            1,
            $crawler->filter("h1:contains('Amigos Ribercan')"),
            'We are on Amigos Ribercan page'
        );
    }
}
