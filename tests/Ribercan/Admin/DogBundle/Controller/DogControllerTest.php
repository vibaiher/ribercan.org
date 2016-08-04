<?php

namespace Tests\Ribercan\Admin\DogBundle\Controller;

use BladeTester\HandyTestsBundle\Model\HandyTestCase;
use BladeTester\HandyTestsBundle\Model\TableTruncator;

use Ribercan\Admin\DogBundle\Entity\Dog;
use Tests\Ribercan\Admin\DogBundle\Factory\DogCreator;

class DogControllerTest extends HandyTestCase
{
    function setUp(array $auth = [])
    {
        parent::setUp($auth);
        $this->truncateTables(['dogs']);
    }

    /**
     * @test
     */
    function itShouldBeAbleToCreateANewDog()
    {
        $crawler = $this->visit('admin_dogs_index');
        $crawler = $this->client->click($crawler->selectLink('Añadir perro en adopción')->link());

        // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form(array(
            'dog[name]'  => 'Test',
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
            'dog[size]'  => Dog::SMALL,
            'dog[urgent]'  => false
        ));

        $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        // Check data in the show view
        $this->assertGreaterThan(0, $crawler->filter('td:contains("Test")')->count(), 'Missing element td:contains("Test")');
    }

    /**
     * @test
     */
    function itShouldBeAbleToEditAnExistingDog()
    {
        // Create a new dog
        $dog = $this->createDog();

        // Create a new entry in the database
        $crawler = $this->visit('admin_dogs_show', array('id' => $dog->getId()));
        // Edit the entity
        $crawler = $this->client->click($crawler->selectLink('Edit')->link());

        $form = $crawler->selectButton('Update')->form(array(
            'dog[name]'  => 'Foo',
            'dog[urgent]'  => true
        ));

        $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        // Check the element contains an attribute with value equals "Foo"
        $this->assertGreaterThan(0, $crawler->filter('[value="Foo"]')->count(), 'Missing element [value="Foo"]');
    }

    /**
     * @test
     */
    function itShoulbBeAbleToDeleteAnExistingDog()
    {
        // Create a new dog
        $dog = $this->createDog();

        // Create a new entry in the database
        $crawler = $this->visit('admin_dogs_show', array('id' => $dog->getId()));
        // Delete the entity
        $this->client->submit($crawler->selectButton('Delete')->form());
        $crawler = $this->client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertNotRegExp('/Foo/', $this->client->getResponse()->getContent());
    }

    private function createDog()
    {
        $dog_creator = new DogCreator($this->em);

        return $dog_creator->create();
    }
}
