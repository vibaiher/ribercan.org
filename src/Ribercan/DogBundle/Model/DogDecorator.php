<?php

namespace Ribercan\DogBundle\Model;

use Ribercan\Admin\DogBundle\Entity\Dog;

class DogDecorator
{
    public function __construct(Dog $dog)
    {
        $this->dog = $dog;
    }

    public function getId()
    {
        return $this->dog->getId();
    }

    public function getName()
    {
        return $this->dog->getName();
    }

    public function getSex()
    {
        $translations = [
            Dog::MALE => '<span class="male">♂</span>',
            Dog::FEMALE => '<span class="female">♀</span>'
        ];

        return $translations[$this->dog->getSex()];
    }

    public function getBirthday()
    {
        return $this->dog->getBirthday()->format("d/m/Y");
    }

    public function getJoinDate()
    {
        return $this->dog->getJoinDate()->format("d/m/Y");
    }

    public function getSterilized()
    {
        return $this->dog->getSterilized() ? 'Esterilizado' : 'Se entrega con compromiso de castración';
    }

    public function getGodfather()
    {
        return $this->dog->getGodfather();
    }

    public function getDescription()
    {
        return $this->dog->getDescription();
    }

    public function getSize()
    {
        $translations = [
            Dog::PUPPY => 'Cachorro',
            Dog::SMALL => 'Tamaño pequeño',
            Dog::MEDIUM => 'Tamaño mediano',
            Dog::BIG => 'Tamaño grande'
        ];

        return $translations[$this->dog->getSize()];
    }

    public function getUrgent()
    {
        return $this->dog->getUrgent();
    }

    public function getVideo()
    {
        return $this->dog->getVideo();
    }

    public function getVideoId()
    {
        return $this->getVideo();
    }

    public function getVideoUrl()
    {
        $videoId = $this->getVideoId();
        return "https://www.youtube.com/embed/{$videoId}";
    }

    public function getVideoThumbnail()
    {
        $videoId = $this->getVideoId();
        return "https://img.youtube.com/vi/{$videoId}/maxresdefault.jpg";
    }

    public function getImages()
    {
        return $this->dog->getImages();
    }

    public function getMainImage()
    {
        $defaultImage = 'images/logo__big.jpg';
        return $this->dog->getMainImage() ? $this->dog->getMainImage()->getWebPath() : $defaultImage;
    }
}
