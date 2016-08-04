<?php

namespace tests\Ribercan\DogBundle\Feature;

use Tests\Ribercan\Admin\DogBundle\Factory\DogCreator;

use BladeTester\HandyTestsBundle\Model\HandyTestCase;
use BladeTester\HandyTestsBundle\Model\TableTruncator;

use Ribercan\Admin\DogBundle\Entity\Dog;

class DogPageTest extends HandyTestCase
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
    public function whenIVisitADogPageThenISeeAllTheDogInformation()
    {
        $this->createDogWithName('My Dog');

        $crawler = $this->visit('dogs_in_adoption');
        $crawler = $this->client->click($crawler->selectLink('My Dog')->link());

        $this->assertCount(
            1,
            $crawler->filter('html:contains("My Dog")'),
            'Appears the dog name'
        );
        $this->assertCount(
            1,
            $crawler->filter('html:contains("Grande")'),
            'Appears the dog size'
        );
        $this->assertCount(
            1,
            $crawler->filter('html:contains("♀")'),
            'Appears the dog sex'
        );
        $this->assertCount(
            1,
            $crawler->filter('html:contains("años")'),
            'Appears the dog age'
        );
        $this->assertCount(
            1,
            $crawler->filter('html:contains("16/01/2016")'),
            'Appears the date when the dog joined Ribercan'
        );
        $this->assertCount(
            1,
            $crawler->filter('html:contains("Esterilizado")'),
            'Appears if the dog is sterilized'
        );
        $this->assertCount(
            1,
            $crawler->filter('html:contains("Apadrinado por Vicente")'),
            'Appears if the dog has a godfather'
        );
        $this->assertCount(
            1,
            $crawler->filter('html:contains("The dog description")'),
            'Appears the dog description'
        );
    }

    /**
     * @test
     */
    public function whenIVisitADogPageThenIAlsoSeeThreeUrgentAdoptions()
    {
        $dog = $this->dogCreator->create(array('name' => 'My dog', 'urgent' => false));
        $urgent_dog_one = $this->dogCreator->create(array('name' => 'Urgent dog one', 'urgent' => true));
        $urgent_dog_two = $this->dogCreator->create(array('name' => 'Urgent dog two', 'urgent' => true));
        $urgent_dog_three = $this->dogCreator->create(array('name' => 'Urgent dog three', 'urgent' => true));
        $urgent_dog_four = $this->dogCreator->create(array('name' => 'Urgent dog four', 'urgent' => true));

        $crawler = $this->visit('dog_in_adoption', array('id' => $dog->getId()));

        $this->assertCount(
            1,
            $crawler->filter('a:contains("Urgent dog one")'),
            'Appears the urgent adoption 1'
        );
        $this->assertCount(
            1,
            $crawler->filter('a:contains("Urgent dog two")'),
            'Appears the urgent adoption 2'
        );
        $this->assertCount(
            1,
            $crawler->filter('a:contains("Urgent dog three")'),
            'Appears the urgent adoption 3'
        );
        $this->assertCount(
            0,
            $crawler->filter('a:contains("Urgent dog four")'),
            'Not appears the urgent adoption 4'
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
