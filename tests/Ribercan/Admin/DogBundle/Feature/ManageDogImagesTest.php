<?php

namespace Tests\Ribercan\Admin\DogBundle\Feature;

use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Tests\Ribercan\Helper\Factory\Dog as DogFactory;
use Tests\Ribercan\Helper\PageObject\Admin\Dogs as AdminDogsPage;

use Ribercan\Admin\DogBundle\Entity\Dog;

class ManageDogImagesTest extends WebTestCase
{
    private $images;

    /**
     * @before
     */
    function init()
    {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW'   => 'secret',
        ));
        $entity_manager = $client->
            getContainer()->
            get('doctrine.orm.default_entity_manager');

        $purger = new ORMPurger($entity_manager);
        $purger->purge();

        $this->page = new AdminDogsPage($client);
        $this->factory = new DogFactory($entity_manager);
    }

    /**
     * @test
     */
    function userShouldBeAbleToUploadANewDogImage()
    {
        $dog = $this->factory->create(
            array(
                'name' => 'Small Dog',
                'size' => Dog::SMALL
            )
        );

        $this->page->goToImagesOf($dog);

        $this->assertEquals(
            0,
            $this->page->imagesCount(),
            'Dog does not have images'
        );

        $this->page->upload('dog.jpg', __DIR__ . '/images/dog.jpg');

        $this->assertEquals(
            1,
            $this->page->imagesCount(),
            'Dog has a new image'
        );
    }

    /**
     * @test
     */
    function userShouldBeAbleToMarkAImageAsCover()
    {
        $dog = $this->factory->create(
            array(
                'name' => 'Small Dog',
                'size' => Dog::SMALL
            )
        );

        $this->page->goToImagesOf($dog);
        $this->page->upload('dog.jpg', __DIR__ . '/images/dog.jpg');
        $this->page->upload('dog2.jpg', __DIR__ . '/images/dog2.jpg');

        $this->page->goToDogProfile($dog);
        $currentCover = $this->page->coverImageAlt();

        $this->page->goToImagesOf($dog);
        $this->page->setSecondImageAsCover();

        $this->page->goToDogProfile($dog);
        $newCover = $this->page->coverImageAlt();

        $this->assertNotEquals(
            $newCover,
            $currentCover,
            'Dog has a new cover image'
        );
    }

    /**
     * @test
     */
    function userShouldBeAbleToDeleteAnImage()
    {
        $dog = $this->factory->create(
            array(
                'name' => 'Small Dog',
                'size' => Dog::SMALL
            )
        );

        $this->page->goToImagesOf($dog);
        $this->page->upload('dog.jpg', __DIR__ . '/images/dog.jpg');
        $this->page->upload('dog2.jpg', __DIR__ . '/images/dog2.jpg');

        $this->assertEquals(
            2,
            $this->page->imagesCount(),
            'Dog has a new image'
        );

        $this->page->deleteSecondImage();

        $this->assertEquals(
            1,
            $this->page->imagesCount(),
            'Last dog image is deleted'
        );
    }
}
