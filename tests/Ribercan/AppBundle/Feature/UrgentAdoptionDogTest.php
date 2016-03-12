<?php

namespace Test\Ribercan\AppBundle\Feature;

use BladeTester\HandyTestsBundle\Model\HandyTestCase;
use BladeTester\HandyTestsBundle\Model\TableTruncator;

use Ribercan\Admin\DogBundle\Entity\Dog;

class UrgentAdoptionDogTest extends HandyTestCase
{
    public function setUp(array $auth = [])
    {
        parent::setUp($auth);
        $this->truncateTables(['dogs']);
    }

    /**
     * @test
     */
    public function whenAUrgentAdoptionDogIsCreatedItAppearsInTheHomepage()
    {
        $this->createUrgentAdoptionForDogWithName('My Urgent Adoption Dog');

        $crawler = $this->visit('homepage');

        $this->assertCount(
            1,
            $crawler->filter('a:contains("My Urgent Adoption Dog")'),
            'The urgent adoption dog created appears in the homepage'
        );
    }

    private function createUrgentAdoptionForDogWithName($dogName)
    {
        $crawler = $this->visit('admin_dogs');
        $crawler = $this->client->click($crawler->selectLink('Añadir perro en adopción')->link());

        $dogAttributes = array(
            'dog[name]' => $dogName,
            'dog[urgent]' => true,
            'dog[sex]'  => Dog::MALE,
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
            'dog[godfather]'  => '',
            'dog[description]'  => 'Custom description',
            'dog[size]'  => Dog::PUPPY,
        );

        $form = $crawler->selectButton('Create')->form($dogAttributes);

        $this->client->submit($form);
        $this->client->followRedirect();
    }
}
