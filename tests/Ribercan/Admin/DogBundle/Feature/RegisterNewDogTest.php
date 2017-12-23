<?php

namespace Tests\Ribercan\Admin\DogBundle\Feature;

use BladeTester\HandyTestsBundle\Model\HandyTestCase;
use BladeTester\HandyTestsBundle\Model\TableTruncator;

use Ribercan\Admin\DogBundle\Entity\Dog;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Tests\Ribercan\Helper\Factory\Dog as DogCreator;

class RegisterNewDogTest extends HandyTestCase
{
    private $images;

    function setUp(array $auth = [])
    {
        $auth = array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW'   => 'secret',
        );
        parent::setUp($auth);
        $this->truncateTables(['dogs', 'dog_images']);
        $this->dogCreator = new DogCreator($this->em);
        $this->repository = $this->em->getRepository('RibercanAdminDogBundle:Dog');
    }

    /**
     * @test
     */
    function userShouldBeAbleToUploadADogImage()
    {
        $image = new UploadedFile(
            __DIR__ . '/images/dog.jpg',
            'dog.jpg'
        );

        $crawler = $this->visit('admin_dogs_index');
        $crawler = $this->client->click($crawler->selectLink('Añadir perro en adopción')->link());

        // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form(array(
            'dog[name]' => 'Blake',
            'dog[sex]' => Dog::MALE,
            'dog[birthday]' => array(
                'year' => 2013,
                'month' => 8,
                'day' => 26
            ),
            'dog[joinDate]' => array(
                'year' => 2013,
                'month' => 9,
                'day' => 18
            ),
            'dog[description]' => 'He is the cutest dog in the world.',
            'dog[size]' => Dog::SMALL,
            'dog[urgent]' => true,
            'dog[uploadedImages][0]' => $image
        ));

        $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        $this->assertCount(
            1,
            $crawler->filter('td:contains("Blake")'),
            'Dog was created'
        );
        $this->assertCount(
            1,
            $crawler->filter('img.img-thumbnail'),
            'Dog images were uploaded'
        );
    }

    /**
     * @test
     */
    function userShouldBeAbleToEditDogJoinDate()
    {
        $dog = $this->dogCreator->create(
            array(
                'name' => 'Small Dog',
                'size' => Dog::SMALL
            )
        );

        $crawler = $this->visit('admin_dogs_index');
        $crawler = $this->client->click($crawler->selectLink('Editar')->link());

        // Fill in the form and submit it
        $form = $crawler->selectButton('Update')->form(array(
            'dog[joinDate]' => array(
                'year' => 2000,
                'month' => 9,
                'day' => 18
            )
        ));

        $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        $updatedDog = $this->repository->find($dog->getId());

        $expectedDate = new \DateTime("2000/09/18");
        $this->assertEquals(
            $expectedDate->format("Y-m-d"),
            $updatedDog->getJoinDate()->format("Y-m-d"),
            'Dog join date was updated'
        );
    }
}
