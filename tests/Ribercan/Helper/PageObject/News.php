<?php

namespace Tests\Ribercan\Helper\PageObject;

use Tests\Ribercan\Helper\PageObject\Announcement;
use Tests\Ribercan\Helper\PageObject\PageObject;

class News extends PageObject
{
    const NEWS_PAGE_TITLE = 'Archivo de noticias';

    public function go_to_news()
    {
        $this->crawler = $this->client->request('GET', '/');
        $link = $this->crawler->filter('a:contains("Noticias")')->link();
        $this->crawler = $this->client->click($link);

        if ($this->page_title() != self::NEWS_PAGE_TITLE) {
            throw new \Exception("News page is not accesible");
        }
    }

    public function first_announcement_title()
    {
        return $this->crawler->
            filter(".ListItem > article > h2 > a")->
            first()->
            text();
    }

    public function click_on_latest_announcement()
    {
        $link = $this->crawler->
            filter(".ListItem > article > h2 > a")->
            first()->
            link();
        $this->crawler = $this->client->click($link);
        $announcement_page = new Announcement($this->client, $this->crawler);

        return $announcement_page;
    }

    private function page_title()
    {
        return $this->crawler->
            filter('h1')->
            text();
    }
}