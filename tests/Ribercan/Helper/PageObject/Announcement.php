<?php

namespace Tests\Ribercan\Helper\PageObject;

class Announcement
{
    private $client;
    private $crawler;

    public function __construct($client, $crawler = null)
    {
        $this->client = $client;
        $this->crawler = $crawler;
    }

    public function title()
    {
        return $this->crawler->
            filter('h1')->
            text();
    }

    public function body()
    {
        return $this->crawler->
            filter('.news__body')->
            html();
    }

    public function image()
    {
        return $this->crawler->
            filter('.news__sidebar > img')->
            attr('src');
    }
}