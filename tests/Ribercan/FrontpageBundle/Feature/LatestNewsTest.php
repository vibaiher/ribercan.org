<?php

namespace Tests\Ribercan\FrontpageBundle\Feature;

use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use Tests\Ribercan\Helper\PageObject\Frontpage;
use Tests\Ribercan\Helper\Factory\Announcement as AnnouncementFactory;

class LatestNewsTest extends WebTestCase
{
    private $page;
    private $factory;

    /**
     * @before
     */
    function init()
    {
        $client = static::createClient();
        $entity_manager = $client->
            getContainer()->
            get('doctrine.orm.default_entity_manager');

        $purger = new ORMPurger($entity_manager);
        $purger->purge();

        $this->page = new Frontpage($client);
        $this->factory = new AnnouncementFactory($entity_manager);
    }

    /**
     * @test
     */
    public function visitorsSeeLatestAnnouncementsInFrontpage()
    {
        $announcementOne = $this->factory->create(array('title' => 'One'));
        $announcementTwo = $this->factory->create(array('title' => 'Two'));
        $announcementThree = $this->factory->create(array('title' => 'Three'));
        $announcementFour = $this->factory->create(array('title' => 'Four'));
        $announcementFive = $this->factory->create(array('title' => 'Five'));

        $this->page->go_to_frontpage();

        $fixed_video_announcement = 1;
        $expected_news = 4 + $fixed_video_announcement;
        $this->assertCount(
            $expected_news,
            $this->page->latest_news(),
            'Only shows the four latest news in the frontpage'
        );
    }
}
