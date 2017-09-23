<?php

namespace Tests\Ribercan\ShopBundle\Feature;

use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use Tests\Ribercan\Helper\PageObject\Shop as ShopPage;
use Tests\Ribercan\Helper\Factory\Product as ProductFactory;

class ProductsTest extends WebTestCase
{
    private $page;
    private $factory;

    /**
     * @before
     */
    function init()
    {
        $client = static::createClient();
        $entity_manager = $client->
            getContainer()->
            get('doctrine.orm.default_entity_manager');

        $purger = new ORMPurger($entity_manager);
        $purger->purge();

        $this->page = new ShopPage($client);
        $this->factory = new ProductFactory($entity_manager);
    }

    /**
     * @test
     */
    function visitorsSeeProductsViaShopPage()
    {
        $product = $this->factory->create(
            array(
                'available' => true
            )
        );

        $this->page->goToShop();

        $this->assertEquals(
            $product->getName(),
            $this->page->firstProductName(),
            'Available product appears in shop page'
        );
    }

    /**
     * @test
     */
    function visitorsSeeOnlyAvailableProductsViaShopPage()
    {
        $this->factory->create(
            array(
                'available' => false
            )
        );

        $this->page->goToShop();

        $this->assertEquals(
            0,
            $this->page->productsCount(),
            'Only shows available products in shop page'
        );
    }
}
