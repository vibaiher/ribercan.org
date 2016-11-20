<?php

namespace Ribercan\NewsBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Ribercan\NewsBundle\Entity\Announcement;

class LoadNewsData extends AbstractFixture implements OrderedFixtureInterface
{
    const MAX = 15;

    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= self::MAX; $i++)
        {
            $publishedAt = $this->generateDifferentDateTimeFor($i);
            $announcement = new Announcement();

            $announcement->setTitle("Extra, extra! Ribercan {$i}");
            $announcement->setSummary("¡¡Menudo noticion os traemos!!");
            $announcement->setBody(
                '<p>Hola!</p><p>Esto es una <b>noticia</b> muy chula.</p>'
            );
            $announcement->setPublishedAt($publishedAt);

            $manager->persist($announcement);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }

    private function generateDifferentDateTimeFor($index)
    {
        $datetime = new \DateTime();
        $different_interval = new \DateInterval("PT{$index}S");
        $datetime->add($different_interval);

        return $datetime;
    }
}
