<?php

namespace Tests\Ribercan\Helper\Factory;

use Ribercan\Admin\DogBundle\Entity\Dog as DogEntity;

class Dog
{
    private $entity_manager;

    public function __construct($entity_manager)
    {
        $this->entity_manager = $entity_manager;
    }

    public function create(array $attributes = [])
    {
        $dog = new DogEntity();
        $dog->setName(isset($attributes['name']) ? $attributes['name'] : 'Cory');
        $dog->setSex(isset($attributes['sex']) ? $attributes['sex'] : DogEntity::MALE);
        $dog->setSize(isset($attributes['size']) ? $attributes['size'] : DogEntity::BIG);
        $dog->setSterilized(DogEntity::STERILIZED);
        $dog->setBirthday(isset($attributes['birthday']) ? $attributes['birthday'] : new \Datetime());
        $dog->setJoinDate(new \Datetime());
        $dog->setUrgent(isset($attributes['urgent']) ? $attributes['urgent'] : false);

        $this->entity_manager->persist($dog);

        $this->entity_manager->flush();

        return $dog;
    }
}
