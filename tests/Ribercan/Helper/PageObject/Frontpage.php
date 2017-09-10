<?php

namespace Tests\Ribercan\Helper\PageObject;

use Tests\Ribercan\Helper\PageObject\PageObject;

class Frontpage extends PageObject
{
    public function go_to_frontpage()
    {
        $this->crawler = $this->client->request('GET', '/');

        if ($this->frontpage_cover()->count() != 1) {
            throw new \Exception("Frontpage is not accesible");
        }
    }

    public function latest_news()
    {
        return $this->crawler->
            filter('.list--news > li > article');
    }

    private function frontpage_cover()
    {
        return $this->crawler->filter('img.cover');
    }
}
