<?php

namespace tests\Ribercan\DogBundle\Feature;

use Tests\Ribercan\Admin\DogBundle\Factory\DogCreator;

use BladeTester\HandyTestsBundle\Model\HandyTestCase;
use BladeTester\HandyTestsBundle\Model\TableTruncator;

use Ribercan\Admin\DogBundle\Entity\Dog;

class FilterDogTest extends HandyTestCase
{
    public function setUp(array $auth = [])
    {
        parent::setUp($auth);
        $this->truncateTables(['dogs']);
        $this->dogCreator = new DogCreator($this->em);
    }

    /**
     * @test
     */
    public function filtersDogsBySize()
    {
        $smallDog = $this->dogCreator->create(
            array(
                'name' => 'Small Dog',
                'size' => Dog::SMALL
            )
        );
        $mediumDog = $this->dogCreator->create(
            array(
                'name' => 'Medium Dog',
                'size' => Dog::MEDIUM
            )
        );
        $bigDog = $this->dogCreator->create(
            array(
                'name' => 'Big Dog',
                'size' => Dog::BIG
            )
        );

        $crawler = $this->visit('dogs_in_adoption');

        $filterAttributes = array(
            'dog_filter[size]'  => Dog::BIG
        );

        $form = $crawler->selectButton('Filter')->form($filterAttributes);

        $crawler = $this->client->submit($form);

        $this->assertCount(
            1,
            $crawler->filter('article.animal'),
            'Only appears an occurrence'
        );

        $this->assertCount(
            1,
            $crawler->filter('html:contains("Big Dog")'),
            'Filter list shows a dog with the selected size'
        );
    }

    /**
     * @test
     */
    public function filtersDogsByAge()
    {
        $today = new \DateTimeImmutable();
        $twoMonthsAgo = $today->add(\DateInterval::createFromDateString('2 months ago'));
        $elevenMonthsAgo = $today->add(\DateInterval::createFromDateString('11 months ago'));
        $moreThanAYearAgo = $today->add(\DateInterval::createFromDateString('1 year and 1 day ago'));

        $this->dogCreator->create(
            array(
                'name' => 'Puppy one',
                'birthday' => $twoMonthsAgo
            )
        );
        $this->dogCreator->create(
            array(
                'name' => 'Puppy two',
                'birthday' => $elevenMonthsAgo
            )
        );
        $dog = $this->dogCreator->create(
            array(
                'name' => 'Adult dog',
                'birthday' => $moreThanAYearAgo
            )
        );

        $crawler = $this->visit('dogs_in_adoption');

        $filterAttributes = array(
            'dog_filter[age]'  => Dog::PUPPY
        );

        $form = $crawler->selectButton('Filter')->form($filterAttributes);

        $crawler = $this->client->submit($form);

        $this->assertCount(
            2,
            $crawler->filter('article.animal'),
            'Only appears an occurrence'
        );

        $this->assertCount(
            0,
            $crawler->filter('html:contains("Adult dog")'),
            'Adults does not appear'
        );
    }
}
