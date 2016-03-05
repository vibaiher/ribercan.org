<?php

namespace Tests\Ribercan\Admin\DogBundle\Factory;

use Ribercan\Admin\DogBundle\Entity\Dog;

class DogCreator
{
    public static function create($entity_manager)
    {
        $dog = new Dog();
        $dog->setName('Cory');
        $dog->setSex(Dog::MALE);
        $dog->setSize(Dog::BIG);
        $dog->setSterilized(Dog::STERILIZED);
        $dog->setBirthday(new \Datetime());
        $dog->setJoinDate(new \Datetime());
        $dog->setUrgent(false);

        $entity_manager->persist($dog);

        $entity_manager->flush();

        return $dog;
    }
}
