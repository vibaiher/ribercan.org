<?php

namespace Tests\Ribercan\Helper\PageObject\Admin;

use Symfony\Component\HttpFoundation\File\UploadedFile;

use Ribercan\EventBundle\Entity\Event as EventEntity;
use Tests\Ribercan\Helper\PageObject\PageObject;

class Event extends PageObject
{
    const ADD_EVENT_PAGE_TITLE = 'Añadir un evento';
    const EDIT_EVENT_PAGE_TITLE = 'Editar un evento';

    private $form_data;

    public function __construct($client, $crawler = null)
    {
        $this->form_data = array();
        parent::__construct($client, $crawler);
    }

    public function go_to_new_event_page()
    {
        $this->crawler = $this->client->request('GET', '/admin');
        $link = $this->crawler->filter('a:contains("Eventos")')->link();
        $this->crawler = $this->client->click($link);
        $link = $this->crawler->filter('a:contains("Añadir un evento")')->link();
        $this->crawler = $this->client->click($link);


        if ($this->page_title() != self::ADD_EVENT_PAGE_TITLE) {
            throw new \Exception("Add event page is not accesible");
        }
    }

    public function go_to_event_page(EventEntity $event)
    {
        $this->crawler = $this->client->request('GET', '/admin');
        $link = $this->crawler->filter('a:contains("Eventos")')->link();
        $this->crawler = $this->client->click($link);
        $link = $this->crawler->filter("a[href=\"/admin/events/{$event->getId()}/show\"]")->link();
        $this->crawler = $this->client->click($link);


        if ($this->event_title() != $event->getTitle()) {
            throw new \Exception("Event <{$event->getId()}> page is not accesible");
        }
    }

    public function go_to_edit_event_page(EventEntity $event)
    {
        $this->crawler = $this->client->request('GET', '/admin');
        $link = $this->crawler->filter('a:contains("Eventos")')->link();
        $this->crawler = $this->client->click($link);
        $link = $this->crawler->filter("a[href=\"/admin/events/{$event->getId()}/edit\"]")->link();
        $this->crawler = $this->client->click($link);


        if ($this->page_title() != self::EDIT_EVENT_PAGE_TITLE) {
            throw new \Exception("Edit event <{$event->getId()}> page is not accesible");
        }
    }

    public function fill_title_with($title)
    {
        $this->form_data['event[title]'] = $title;
    }

    public function fill_summary_with($summary)
    {
        $this->form_data['event[summary]'] = $summary;
    }

    public function fill_body_with($body)
    {
        $this->form_data['event[body]'] = $body;
    }

    public function upload_image($name)
    {
        $folder = __DIR__ . '/../../../Helper/Images';

        $uploaded_image = new UploadedFile(
            "{$folder}/{$name}",
            $name
        );

        $this->form_data['event[uploadedImage]'] = $uploaded_image;
    }

    public function click_on_publish()
    {
        $this->submit_button('Publish');
    }

    public function click_on_update()
    {
        $this->submit_button('Update');
    }

    public function click_on_delete()
    {
        $form = $this->crawler->
            selectButton('Delete')->
            form();

        $this->client->submit($form);
        $this->crawler = $this->client->followRedirect();
    }

    public function events_table()
    {
        return $this->crawler->
            filter('table.table')->
            html();
    }

    public function event_title()
    {
        return $this->crawler->
            filter('#event_title')->
            text();
    }

    public function event_summary()
    {
        return $this->crawler->
            filter('#event_summary')->
            text();
    }

    public function event_body()
    {
        return $this->crawler->
            filter('#event_body')->
            html();
    }

    public function event_image()
    {
        return $this->crawler->
            filter('#event_image')->
            attr('alt');
    }

    public function event_published_at()
    {
        return $this->crawler->
            filter('#event_published_at')->
            text();
    }

    private function page_title()
    {
        return $this->crawler->
            filter('h1')->
            text();
    }

    private function submit_button($button)
    {
        $form = $this->crawler->
            selectButton($button)->
            form($this->form_data);

        $this->client->submit($form);
        $this->crawler = $this->client->followRedirect();
    }
}