<?php

namespace tests\Ribercan\DogBundle\Feature;

use Tests\Ribercan\Admin\DogBundle\Factory\DogCreator;

use BladeTester\HandyTestsBundle\Model\HandyTestCase;
use BladeTester\HandyTestsBundle\Model\TableTruncator;

use Ribercan\Admin\DogBundle\Entity\Dog;

class AdoptableDogsPageTest extends HandyTestCase
{
    public function setUp(array $auth = [])
    {
        parent::setUp($auth);
        $this->truncateTables(['dogs']);
        $this->dogCreator = new DogCreator($this->em);
    }

    /**
     * @test
     */
    public function whenADogIsCreatedThenIsShownInTheAdoptionsPage()
    {
        $this->createDogWithName('My Dog');

        $crawler = $this->visit('dogs_in_adoption');

        $this->assertCount(
            1,
            $crawler->filter('a:contains("My Dog")'),
            'The dog created appears in the adoptions page'
        );
    }

    private function createDogWithName($dogName)
    {
        $crawler = $this->visit('admin_dogs_index');
        $crawler = $this->client->click($crawler->selectLink('Añadir perro en adopción')->link());

        $dogAttributes = array(
            'dog[name]' => $dogName,
            'dog[urgent]' => false,
            'dog[sex]'  => Dog::FEMALE,
            'dog[birthday]'  => array(
                'year' => 2010,
                'month' => 7,
                'day' => 16
            ),
            'dog[joinDate]'  => array(
                'year' => 2016,
                'month' => 1,
                'day' => 16
            ),
            'dog[sterilized]'  => Dog::STERILIZED,
            'dog[godfather]'  => 'Vicente',
            'dog[description]'  => 'The dog description',
            'dog[size]'  => Dog::BIG
        );

        $form = $crawler->selectButton('Create')->form($dogAttributes);

        $this->client->submit($form);
        $this->client->followRedirect();
    }
}
