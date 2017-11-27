<?php

namespace Tests\Ribercan\Helper\PageObject\Admin;

use Tests\Ribercan\Helper\PageObject\PageObject;

use Symfony\Component\HttpFoundation\File\UploadedFile;

use Ribercan\Admin\DogBundle\Entity\Dog;

class Dogs extends PageObject
{
    const DOG_IMAGES_PAGE_TITLE = 'Manage dog images';

    public function __construct($client, $crawler = null)
    {
        $this->form_data = array();
        parent::__construct($client, $crawler);
    }

    public function goToImagesOf(Dog $dog)
    {
        $this->crawler = $this->client->request('GET', "/admin/dogs/{$dog->getId()}/images");

        if ($this->pageTitle() != "Imágenes de \"{$dog->getName()}\"") {
            throw new \Exception("Dog images page for <id: {$dog->getId()}> is not accesible");
        }
    }

    public function goToDogProfile(Dog $dog)
    {
        $this->crawler = $this->client->request('GET', "/dogs/{$dog->getId()}");
    }

    public function coverImageAlt()
    {
        return $this->crawler->
            filter('section.section--animal')->
            extract(array('style'))[0];
    }

    public function upload($name, $source)
    {
        $image = new UploadedFile(
            $source,
            $name
        );

        $form = $this->crawler->
            selectButton('Upload')->
            form(array(
                'dog_image[uploadedImages][0]' => $image
            )
        );

        $this->crawler = $this->client->submit($form);
    }

    public function setSecondImageAsCover()
    {
        $secondPosition = 1;
        $link = $this->crawler->filter("a:contains('Poner como foto de perfil')")->eq($secondPosition)->link();
        $this->crawler = $this->client->click($link);
    }

    public function imagesCount()
    {
        return $this->crawler->
            filter('table.table--images > tbody > tr')->
            count();
    }

    private function pageTitle()
    {
        return $this->crawler->
            filter('h1')->
            text();
    }
}
