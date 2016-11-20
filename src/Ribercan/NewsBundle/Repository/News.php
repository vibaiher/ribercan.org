<?php

namespace Ribercan\NewsBundle\Repository;

use Doctrine\ORM\EntityRepository;

class News extends EntityRepository
{
    public function findAllWithNewestFirst()
    {
        $all = $this->findBy(
          array(),
          array('publishedAt' => 'desc')
        );

        return $all;
    }

    public function findLatestNews($limit = null)
    {
        $latest_news = $this->findBy(
          array(),
          array('publishedAt' => 'desc'),
          $limit
        );

        return $latest_news;
    }
}
