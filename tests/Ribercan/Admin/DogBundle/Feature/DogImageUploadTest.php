<?php

namespace Test\Ribercan\Admin\DogBundle\Feature;

use BladeTester\HandyTestsBundle\Model\HandyTestCase;
use BladeTester\HandyTestsBundle\Model\TableTruncator;

use Ribercan\Admin\DogBundle\Entity\Dog;
use Tests\Ribercan\Admin\DogBundle\Factory\DogCreator;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class DogImageUploadTest extends HandyTestCase
{
    private $dog;
    private $image;

    function setUp(array $auth = [])
    {
        parent::setUp($auth);
        $this->truncateTables(['dogs', 'dog_images']);
        $this->dog = $this->createDog();
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

        $crawler = $this->visit('dog_images_index', array('dog_id' => $this->dog->getId()));
        $link = $crawler->selectLink('Añadir nuevas imágenes')->link();
        $crawler = $this->client->click($link);

        $form = $crawler->selectButton('Subir')->form(array(
            'form[name]'  => 'Image Name',
            'form[file]'  => __DIR__ . '/images/dog.jpg',
        ));

        $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        $this->assertCount(
            1,
            $crawler->filter('html:contains("Image uploaded succesfully")')
        );
    }

    private function createDog()
    {
        $dog_creator = new DogCreator($this->em);

        return $dog_creator->create();
    }
}
