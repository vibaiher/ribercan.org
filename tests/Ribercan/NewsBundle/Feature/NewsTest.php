<?php

namespace Tests\Ribercan\NewsBundle\Feature;

use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use Tests\Ribercan\Helper\PageObject\News as NewsPage;
use Tests\Ribercan\Helper\Factory\Announcement as AnnouncementFactory;

class NewsTest extends WebTestCase
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

        $this->page = new NewsPage($client);
        $this->factory = new AnnouncementFactory($entity_manager);
    }

    /**
     * @test
     */
    function visitorsSeeLatestAnnouncementsViaNewsPage()
    {
        $announcement = $this->factory->create();

        $this->page->go_to_news();

        $this->assertEquals(
            $announcement->getTitle(),
            $this->page->first_announcement_title(),
            'Latest announcements appear in news page'
        );
    }

    /**
     * @test
     */
    function visitorsCanAccessLatestAnnouncementsViaNewsPage()
    {
        $announcement = $this->factory->create();

        $this->page->go_to_news();

        $announcement_page = $this->page->click_on_latest_announcement();

        $this->assertEquals(
            $announcement->getTitle(),
            $announcement_page->title(),
            'Title is visible in announcement page'
        );
        $this->assertEquals(
            $announcement->getBody(),
            $announcement_page->body(),
            'Body is visible in announcement page'
        );
        $this->assertEquals(
            $announcement->getImage()->getWebPath(),
            $announcement_page->image(),
            'Image is present in announcement page'
        );
    }
}
