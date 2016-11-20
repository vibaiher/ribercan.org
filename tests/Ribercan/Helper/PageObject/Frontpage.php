<?php

namespace Tests\Ribercan\Helper\PageObject;

class Frontpage {
    const FRONTPAGE_TITLE = 'Ribercan';

    private $client;
    private $crawler;

    public function __construct($client, $crawler = null)
    {
        $this->client = $client;
        $this->crawler = $crawler;
    }

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