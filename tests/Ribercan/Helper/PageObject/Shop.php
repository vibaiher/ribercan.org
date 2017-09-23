<?php

namespace Tests\Ribercan\Helper\PageObject;

use Tests\Ribercan\Helper\PageObject\Product;
use Tests\Ribercan\Helper\PageObject\PageObject;

class Shop extends PageObject
{
    const SHOP_PAGE_TITLE = 'Tienda benéfica';

    function goToShop()
    {
        $this->crawler = $this->client->request('GET', '/');
        $link = $this->crawler->filter('a:contains("Tienda")')->link();
        $this->crawler = $this->client->click($link);

        if ($this->pageTitle() != self::SHOP_PAGE_TITLE) {
            throw new \Exception("Shop page is not accesible");
        }
    }

    function firstProductName()
    {
        return $this->crawler->
            filter(".ListItem > article p.name")->
            first()->
            text();
    }

    function productsCount()
    {
        return $this->crawler->filter('.product')->count();
    }

    private function pageTitle()
    {
        return $this->crawler->filter('h1')->text();
    }
}
