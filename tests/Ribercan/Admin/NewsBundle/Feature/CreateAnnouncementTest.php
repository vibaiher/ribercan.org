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
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW'   => 'secret',
        ));
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

        $this->page->click_on_publish();

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

    /**
     * @test
     */
    function userCanUpdateAnAnnouncement()
    {
        $announcement = $this->factory->create();

        $this->page->go_to_edit_announcement_page($announcement);

        $this->page->fill_title_with('Otro título');

        $this->page->click_on_update();

        $this->assertEquals(
            'Otro título',
            $this->page->announcement_title(),
            'User can update the announcement\'s title'
        );
        $this->assertEquals(
            $announcement->getSummary(),
            $this->page->announcement_summary(),
            'Summary is not changed because user do not updated it'
        );
        $this->assertEquals(
            $announcement->getBody(),
            $this->page->announcement_body(),
            'Summary is not changed because user do not updated it'
        );
        $this->assertEquals(
            $announcement->getImage()->getName(),
            $this->page->announcement_image(),
            'Summary is not changed because user do not updated it'
        );
        $this->assertEquals(
            $announcement->getPublishedAt()->format('d/m/Y'),
            $this->page->announcement_published_at(),
            'System does not updated the announcement\'s publishedAt date'
        );
    }

    /**
     * @test
     */
    function userCanDeleteAnAnnouncement()
    {
        $announcement = $this->factory->create();

        $this->page->go_to_announcement_page($announcement);

        $this->page->click_on_delete();

        $this->assertNotContains(
            $announcement->getTitle(),
            $this->page->news_table(),
            'Announcement has been removed'
        );
    }

    private function now()
    {
        return new \Datetime();
    }
}
