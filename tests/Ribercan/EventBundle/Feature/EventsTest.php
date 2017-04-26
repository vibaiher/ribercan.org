<?php

namespace Tests\Ribercan\EventBundle\Feature;

use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use Tests\Ribercan\Helper\PageObject\Events as EventsPage;
use Tests\Ribercan\Helper\Factory\Event as EventFactory;

class EventTest extends WebTestCase
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

        $this->page = new EventsPage($client);
        $this->factory = new EventFactory($entity_manager);
    }

    /**
     * @test
     */
    function visitorsSeeLatestEventsViaEventsPage()
    {
        $event = $this->factory->create();

        $this->page->go_to_events();

        $this->assertEquals(
            $event->getTitle(),
            $this->page->first_event_title(),
            'Latest events appear in events page'
        );
    }

    /**
     * @test
     */
    function visitorsCanAccessLatestEventsViaEventsPage()
    {
        $event = $this->factory->create();

        $this->page->go_to_events();

        $event_page = $this->page->click_on_latest_event();

        $this->assertEquals(
            $event->getTitle(),
            $event_page->title(),
            'Title is visible in event page'
        );
        $this->assertEquals(
            $event->getBody(),
            $event_page->body(),
            'Body is visible in event page'
        );
        $this->assertEquals(
            $event->getImage()->getWebPath(),
            $event_page->image(),
            'Image is present in event page'
        );
    }
}
