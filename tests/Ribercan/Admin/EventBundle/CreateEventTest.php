<?php

namespace Tests\Ribercan\Admin\EventBundle\Feature;

use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use Tests\Ribercan\Helper\PageObject\Admin\Event as AdminEventPage;
use Tests\Ribercan\Helper\Factory\Event as EventFactory;

class CreateEventTest extends WebTestCase
{
    private $page;
    private $factory;

    /**
     * @before
     */
    function init()
    {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW'   => 'secret',
        ));
        $entity_manager = $client->
            getContainer()->
            get('doctrine.orm.default_entity_manager');

        $purger = new ORMPurger($entity_manager);
        $purger->purge();

        $this->page = new AdminEventPage($client);
        $this->factory = new EventFactory($entity_manager);
    }

    /**
     * @test
     */
    function userCanPublishAnEvent()
    {
        $this->page->go_to_new_event_page();

        $this->page->fill_title_with('Mi título');
        $this->page->fill_summary_with('Mi resumen');
        $this->page->fill_body_with('<p>Mi cuerpo de la notícia</p>');
        $this->page->upload_image('dog.jpg');

        $this->page->click_on_publish();

        $this->assertEquals(
            'Mi título',
            $this->page->event_title(),
            'User can set the event\'s title'
        );
        $this->assertEquals(
            'Mi resumen',
            $this->page->event_summary(),
            'User can set the event\'s summary'
        );
        $this->assertEquals(
            '<p>Mi cuerpo de la notícia</p>',
            $this->page->event_body(),
            'User can set the event\'s body'
        );
        $this->assertEquals(
            'dog.jpg',
            $this->page->event_image(),
            'User can set the event\'s image'
        );
        $this->assertEquals(
            $this->now()->format('d/m/Y'),
            $this->page->event_published_at(),
            'System sets the event\'s publishedAt date automatically'
        );
    }

    /**
     * @test
     */
    function userCanUpdateAnEvent()
    {
        $event = $this->factory->create();

        $this->page->go_to_edit_event_page($event);

        $this->page->fill_title_with('Otro título');

        $this->page->click_on_update();

        $this->assertEquals(
            'Otro título',
            $this->page->event_title(),
            'User can update the event\'s title'
        );
        $this->assertEquals(
            $event->getSummary(),
            $this->page->event_summary(),
            'Summary is not changed because user do not updated it'
        );
        $this->assertEquals(
            $event->getBody(),
            $this->page->event_body(),
            'Summary is not changed because user do not updated it'
        );
        $this->assertEquals(
            $event->getImage()->getName(),
            $this->page->event_image(),
            'Summary is not changed because user do not updated it'
        );
        $this->assertEquals(
            $event->getPublishedAt()->format('d/m/Y'),
            $this->page->event_published_at(),
            'System does not updated the event\'s publishedAt date'
        );
    }

    /**
     * @test
     */
    function userCanDeleteAnEvent()
    {
        $event = $this->factory->create();

        $this->page->go_to_event_page($event);

        $this->page->click_on_delete();

        $this->assertNotContains(
            $event->getTitle(),
            $this->page->events_table(),
            'Event has been removed'
        );
    }

    private function now()
    {
        return new \Datetime();
    }
}
