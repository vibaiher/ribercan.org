<?php

namespace Tests\Ribercan\Admin\DogBundle\Factory;

use Ribercan\Admin\DogBundle\Entity\Dog;

class DogCreator
{
    private $entity_manager;

    public function __construct($entity_manager)
    {
        $this->entity_manager = $entity_manager;
    }

    public function create(array $attributes = [])
    {
        $dog = new Dog();
        $dog->setName(isset($attributes['name']) ? $attributes['name'] : 'Cory');
        $dog->setSex(Dog::MALE);
        $dog->setSize(Dog::BIG);
        $dog->setSterilized(Dog::STERILIZED);
        $dog->setBirthday(new \Datetime());
        $dog->setJoinDate(new \Datetime());
        $dog->setUrgent(isset($attributes['urgent']) ? $attributes['urgent'] : false);

        $this->entity_manager->persist($dog);

        $this->entity_manager->flush();

        return $dog;
    }
}
