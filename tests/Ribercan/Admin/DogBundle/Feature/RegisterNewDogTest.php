<?php

namespace Tests\Ribercan\Admin\DogBundle\Feature;

use BladeTester\HandyTestsBundle\Model\HandyTestCase;
use BladeTester\HandyTestsBundle\Model\TableTruncator;

use Ribercan\Admin\DogBundle\Entity\Dog;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class RegisterNewDogTest extends HandyTestCase
{
    private $images;

    function setUp(array $auth = [])
    {
        parent::setUp($auth);
        $this->truncateTables(['dogs', 'dog_images']);
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
}
