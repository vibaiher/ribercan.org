<?php

namespace Tests\Ribercan\Helper\PageObject;

use Tests\Ribercan\Helper\PageObject\Event;
use Tests\Ribercan\Helper\PageObject\PageObject;

class Events extends PageObject
{
    const EVENT_PAGE_TITLE = 'Eventos';

    public function go_to_events()
    {
        $this->crawler = $this->client->request('GET', '/');
        $link = $this->crawler->filter('a:contains("Eventos")')->link();
        $this->crawler = $this->client->click($link);

        if ($this->page_title() != self::EVENT_PAGE_TITLE) {
            throw new \Exception("Events page is not accesible ");
        }
    }

    public function first_event_title()
    {
        return $this->crawler->
            filter(".ListItem > article > h2 > a")->
            first()->
            text();
    }

    public function click_on_latest_event()
    {
        $link = $this->crawler->
            filter(".ListItem > article > h2 > a")->
            first()->
            link();
        $this->crawler = $this->client->click($link);
        $event_page = new Event($this->client, $this->crawler);

        return $event_page;
    }

    private function page_title()
    {
        return $this->crawler->
            filter('h1')->
            text();
    }
}