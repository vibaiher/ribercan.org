<?php

namespace Tests\Ribercan\Admin\NewsBundle\Feature;

use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use Tests\Ribercan\Helper\PageObject\Admin\News as AdminNewsPage;
use Tests\Ribercan\Helper\Factory\Announcement as AnnouncementFactory;

class CreateAnnouncementTest extends WebTestCase
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

        $this->page = new AdminNewsPage($client);
        $this->factory = new AnnouncementFactory($entity_manager);
    }

    /**
     * @test
     */
    function userCanPublishAnAnnouncement()
    {
        $this->page->go_to_new_announcement_page();

        $this->page->fill_title_with('Mi título');
        $this->page->fill_summary_with('Mi resumen');
        $this->page->fill_body_with('<p>Mi cuerpo de la notícia</p>');
        $this->page->upload_image('dog.jpg');
        $this->page->submit_announcement();

        $this->assertEquals(
            'Mi título',
            $this->page->announcement_title(),
            'User can set the announcement\'s title'
        );
        $this->assertEquals(
            'Mi resumen',
            $this->page->announcement_summary(),
            'User can set the announcement\'s summary'
        );
        $this->assertEquals(
            '<p>Mi cuerpo de la notícia</p>',
            $this->page->announcement_body(),
            'User can set the announcement\'s body'
        );
        $this->assertEquals(
            'dog.jpg',
            $this->page->announcement_image(),
            'User can set the announcement\'s image'
        );
        $this->assertEquals(
            $this->now()->format('d/m/Y'),
            $this->page->announcement_published_at(),
            'System sets the announcement\'s publishedAt date automatically'
        );
    }

    function userCanUpdateAnAnnouncement()
    {
        $announcement = $this->factory->create();

        $this->page->go_to_news();

        $this->assertEquals(
            $announcement->getTitle(),
            $this->page->first_announcement_title(),
            'Latest announcements appear in news page'
        );
    }

    private function now()
    {
        return new \Datetime();
    }
}
