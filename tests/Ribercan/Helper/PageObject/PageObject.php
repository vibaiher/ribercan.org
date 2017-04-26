<?php

namespace Tests\Ribercan\Helper\PageObject;

abstract class PageObject
{
    protected $client;
    protected $crawler;

    public function __construct($client, $crawler = null)
    {
        $this->client = $client;
        $this->crawler = $crawler;
    }
}
