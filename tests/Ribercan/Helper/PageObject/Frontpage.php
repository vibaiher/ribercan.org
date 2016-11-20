<?php

namespace Tests\Ribercan\Helper\PageObject;

use Tests\Ribercan\Helper\PageObject\PageObject;

class Frontpage extends PageObject
{
    const FRONTPAGE_TITLE = 'Ribercan';

    public function go_to_frontpage()
    {
        $this->crawler = $this->client->request('GET', '/');

        if ($this->frontpage_header_title() != self::FRONTPAGE_TITLE) {
            throw new \Exception("Frontpage is not accesible");
        }
    }

    public function latest_news()
    {
        return $this->crawler->
            filter('.list--news > li > article');
    }

    private function frontpage_header_title()
    {
        return $this->crawler->
            filter('.jumbotron > div > h1')->
            text();
    }
}