<?php

namespace Test\Ribercan\AppBundle\Feature;

use BladeTester\HandyTestsBundle\Model\HandyTestCase;
use BladeTester\HandyTestsBundle\Model\TableTruncator;

use Ribercan\Admin\DogBundle\Entity\Dog;

class AdoptableDogsFullListLinkTest extends HandyTestCase
{
    public function setUp(array $auth = [])
    {
        parent::setUp($auth);
    }

    /**
     * @test
     */
    public function whenIVisitTheFrontPageThenIShouldSeeALinkToTheAdoptableDogsPage()
    {
        $linkName = 'lista completa de animales en espera de adopción';

        $crawler = $this->visit('frontpage');

        $crawler = $this->client->click($crawler->selectLink($linkName)->link());

        $this->assertCount(
            1,
            $crawler->filter('html:contains("Listado de perros en adopción")'),
            'I can visit adoptable dogs page from the frontpage'
        );
    }
}
