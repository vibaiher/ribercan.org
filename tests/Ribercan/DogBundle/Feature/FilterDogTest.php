<?php

namespace Tests\Ribercan\DogBundle\Feature;

use BladeTester\HandyTestsBundle\Model\HandyTestCase;
use BladeTester\HandyTestsBundle\Model\TableTruncator;

use Ribercan\Admin\DogBundle\Entity\Dog;
use Tests\Ribercan\Helper\Factory\Dog as DogCreator;

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
        $this->dogCreator->create(
            array(
                'name' => 'Small Dog',
                'size' => Dog::SMALL
            )
        );
        $this->dogCreator->create(
            array(
                'name' => 'Medium Dog',
                'size' => Dog::MEDIUM
            )
        );
        $this->dogCreator->create(
            array(
                'name' => 'Big Dog',
                'size' => Dog::BIG
            )
        );

        $crawler = $this->visit('dogs_in_adoption');

        $filterAttributes = array(
            'dog_filter[size]'  => Dog::BIG
        );

        $form = $crawler->selectButton('Filtrar')->form($filterAttributes);

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

        $form = $crawler->selectButton('Filtrar')->form($filterAttributes);

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

    /**
     * @test
     */
    public function filtersDogsBySex()
    {
        $this->dogCreator->create(
            array(
                'name' => 'Female dog one',
                'sex' => Dog::FEMALE
            )
        );
        $this->dogCreator->create(
            array(
                'name' => 'Female dog two',
                'sex' => Dog::FEMALE
            )
        );
        $this->dogCreator->create(
            array(
                'name' => 'Male dog',
                'sex' => Dog::MALE
            )
        );

        $crawler = $this->visit('dogs_in_adoption');

        $filterAttributes = array(
            'dog_filter[sex]'  => Dog::FEMALE
        );

        $form = $crawler->selectButton('Filtrar')->form($filterAttributes);

        $crawler = $this->client->submit($form);

        $this->assertCount(
            2,
            $crawler->filter('article.animal'),
            'Only appears female dogs'
        );

        $this->assertCount(
            0,
            $crawler->filter('html:contains("Big Dog")'),
            'Does not show male dogs'
        );
    }

    /**
     * @test
     */
    public function filtersDogsBySexAndAge()
    {
        $today = new \DateTimeImmutable();
        $puppyBirthday = $today->add(\DateInterval::createFromDateString('2 months ago'));
        $adultBirthday = $today->add(\DateInterval::createFromDateString('2 years ago'));

        $this->dogCreator->create(
            array(
                'name' => 'Female Adult',
                'birthday' => $adultBirthday,
                'sex' => Dog::FEMALE
            )
        );
        $this->dogCreator->create(
            array(
                'name' => 'Female Puppy',
                'birthday' => $puppyBirthday,
                'sex' => Dog::FEMALE
            )
        );
        $this->dogCreator->create(
            array(
                'name' => 'Male Adult',
                'birthday' => $adultBirthday,
                'sex' => Dog::MALE
            )
        );
        $this->dogCreator->create(
            array(
                'name' => 'Male Puppy',
                'birthday' => $puppyBirthday,
                'sex' => Dog::MALE
            )
        );

        $crawler = $this->visit('dogs_in_adoption');

        $filterAttributes = array(
            'dog_filter[sex]' => Dog::MALE,
            'dog_filter[age]' => Dog::ADULT
        );

        $form = $crawler->selectButton('Filtrar')->form($filterAttributes);

        $crawler = $this->client->submit($form);

        $this->assertCount(
            1,
            $crawler->filter('article.animal'),
            'Only appears an occurrence'
        );

        $this->assertCount(
            1,
            $crawler->filter('html:contains("Male Adult")'),
            'Shows only dogs filtered by sex and age'
        );
    }

    /**
     * @test
     */
    public function filtersDogsBySexAndSize()
    {
        $this->dogCreator->create(
            array(
                'name' => 'Male Big',
                'size' => Dog::BIG,
                'sex' => Dog::MALE
            )
        );
        $this->dogCreator->create(
            array(
                'name' => 'Male Medium',
                'size' => Dog::MEDIUM,
                'sex' => Dog::MALE
            )
        );
        $this->dogCreator->create(
            array(
                'name' => 'Male Small',
                'size' => Dog::SMALL,
                'sex' => Dog::MALE
            )
        );
        $this->dogCreator->create(
            array(
                'name' => 'Female Small',
                'size' => Dog::SMALL,
                'sex' => Dog::FEMALE
            )
        );

        $crawler = $this->visit('dogs_in_adoption');

        $filterAttributes = array(
            'dog_filter[sex]' => Dog::MALE,
            'dog_filter[size]' => Dog::SMALL
        );

        $form = $crawler->selectButton('Filtrar')->form($filterAttributes);

        $crawler = $this->client->submit($form);

        $this->assertCount(
            1,
            $crawler->filter('article.animal'),
            'Only appears an occurrence'
        );

        $this->assertCount(
            1,
            $crawler->filter('html:contains("Male Small")'),
            'Shows only dogs filtered by sex and age'
        );
    }

    /**
     * @test
     */
    public function filtersDogsByAgeAndSize()
    {
        $today = new \DateTimeImmutable();
        $puppyBirthday = $today->add(\DateInterval::createFromDateString('2 months ago'));
        $adultBirthday = $today->add(\DateInterval::createFromDateString('2 years ago'));

        $this->dogCreator->create(
            array(
                'name' => 'Small Adult',
                'size' => Dog::SMALL,
                'birthday' => $adultBirthday
            )
        );
        $this->dogCreator->create(
            array(
                'name' => 'Medium Puppy',
                'size' => Dog::MEDIUM,
                'birthday' => $puppyBirthday
            )
        );
        $this->dogCreator->create(
            array(
                'name' => 'Medium Adult',
                'size' => Dog::MEDIUM,
                'birthday' => $adultBirthday
            )
        );
        $this->dogCreator->create(
            array(
                'name' => 'Big Puppy',
                'size' => Dog::BIG,
                'birthday' => $puppyBirthday
            )
        );

        $crawler = $this->visit('dogs_in_adoption');

        $filterAttributes = array(
            'dog_filter[size]' => Dog::MEDIUM,
            'dog_filter[age]' => Dog::PUPPY
        );

        $form = $crawler->selectButton('Filtrar')->form($filterAttributes);

        $crawler = $this->client->submit($form);

        $this->assertCount(
            1,
            $crawler->filter('article.animal'),
            'Only appears an occurrence'
        );

        $this->assertCount(
            1,
            $crawler->filter('html:contains("Medium Puppy")'),
            'Shows only dogs filtered by age and size'
        );
    }

    /**
     * @test
     */
    public function filtersDogsByAgeAndSexAndSize()
    {
        $today = new \DateTimeImmutable();
        $puppyBirthday = $today->add(\DateInterval::createFromDateString('2 months ago'));
        $adultBirthday = $today->add(\DateInterval::createFromDateString('2 years ago'));

        $this->dogCreator->create(
            array(
                'name' => 'Female Big Adult',
                'size' => Dog::BIG,
                'birthday' => $adultBirthday,
                'sex' => Dog::FEMALE
            )
        );
        $this->dogCreator->create(
            array(
                'name' => 'Female Medium Puppy',
                'size' => Dog::MEDIUM,
                'birthday' => $puppyBirthday,
                'sex' => Dog::FEMALE
            )
        );
        $this->dogCreator->create(
            array(
                'name' => 'Male Big Puppy',
                'size' => Dog::BIG,
                'birthday' => $puppyBirthday,
                'sex' => Dog::MALE
            )
        );
        $this->dogCreator->create(
            array(
                'name' => 'Female Big Puppy',
                'size' => Dog::BIG,
                'birthday' => $puppyBirthday,
                'sex' => Dog::FEMALE
            )
        );

        $crawler = $this->visit('dogs_in_adoption');

        $filterAttributes = array(
            'dog_filter[size]' => Dog::BIG,
            'dog_filter[age]' => Dog::PUPPY,
            'dog_filter[sex]' => Dog::FEMALE
        );

        $form = $crawler->selectButton('Filtrar')->form($filterAttributes);

        $crawler = $this->client->submit($form);

        $this->assertCount(
            1,
            $crawler->filter('article.animal'),
            'Only appears an occurrence'
        );

        $this->assertCount(
            1,
            $crawler->filter('html:contains("Female Big Puppy")'),
            'Shows only puppies that are big and are females'
        );
    }
}
