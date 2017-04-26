<?php

namespace Tests\Ribercan\Helper\PageObject;

use Tests\Ribercan\Helper\PageObject\PageObject;

class Event extends PageObject
{
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