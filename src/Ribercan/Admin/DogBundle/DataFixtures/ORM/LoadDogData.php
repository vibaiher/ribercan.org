<?php

namespace Ribercan\Admin\DogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ribercan\Admin\DogBundle\Entity\Dog;

class LoadDogData extends AbstractFixture implements OrderedFixtureInterface
{
    const MAX = 25;

    public function load(ObjectManager $manager)
    {
        $sizes = [Dog::SMALL, Dog::MEDIUM, Dog::BIG];

        for ($i = 1; $i < self::MAX; $i++)
        {
            $dog = new Dog();
            $dog->setName("Dog $i");
            $dog->setSex($i % 2 ? Dog::FEMALE : Dog::MALE);
            $dog->setSize($sizes[rand(0, 2)]);
            $dog->setSterilized($i % 2 ? Dog::NOT_STERILIZED_YET : Dog::STERILIZED);
            $dog->setBirthday(new \Datetime());
            $dog->setJoinDate(new \Datetime());
            $dog->setUrgent($i % 2);

            $manager->persist($dog);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}
