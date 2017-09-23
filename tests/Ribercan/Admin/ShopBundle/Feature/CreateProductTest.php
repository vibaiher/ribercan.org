<?php

namespace Tests\Ribercan\Admin\ShopBundle\Feature;

use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use Tests\Ribercan\Helper\PageObject\Admin\Shop as AdminShopPage;
use Tests\Ribercan\Helper\Factory\Product as ProductFactory;

class CreateProductTest extends WebTestCase
{
    private $page;
    private $factory;

    /**
     * @before
     */
    function init()
    {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW'   => 'secret',
        ));
        $entity_manager = $client->
            getContainer()->
            get('doctrine.orm.default_entity_manager');

        $purger = new ORMPurger($entity_manager);
        $purger->purge();

        $this->page = new AdminShopPage($client);
        $this->factory = new ProductFactory($entity_manager);
    }

    /**
     * @test
     */
    function userCanPublishAnProduct()
    {
        $this->page->go_to_new_product_page();

        $this->page->fill_title_with('Mi producto');
        $this->page->fill_description_with('<p>Descripción del producto</p>');
        $this->page->fill_price_with(1.5);
        $this->page->upload_image('dog.jpg');

        $this->page->click_on_publish();

        $this->assertEquals(
            'Mi producto',
            $this->page->product_title(),
            'User can set the product\'s title'
        );
        $this->assertEquals(
            '1.5',
            $this->page->product_price(),
            'User can set the product\'s price'
        );
        $this->assertEquals(
            '<p>Descripción del producto</p>',
            $this->page->product_description(),
            'User can set the product\'s description'
        );
        $this->assertEquals(
            'dog.jpg',
            $this->page->product_image(),
            'User can set the product\'s image'
        );
    }

    /**
     * @test
     */
    function userCanUpdateAnProduct()
    {
        $product = $this->factory->create();

        $this->page->go_to_edit_product_page($product);

        $this->page->fill_title_with('Mi producto 2.0');

        $this->page->click_on_update();

        $this->assertEquals(
            'Mi producto 2.0',
            $this->page->product_title(),
            'User can update the product\'s title'
        );
        $this->assertEquals(
            $product->getDescription(),
            $this->page->product_description(),
            'Description is not changed because user do not updated it'
        );
        $this->assertEquals(
            $product->getPrice(),
            $this->page->product_price(),
            'Price is not changed because user do not updated it'
        );
        $this->assertEquals(
            $product->getImages()[0]->getName(),
            $this->page->product_image(),
            'Image is not changed because user do not updated it'
        );
    }

    /**
     * @test
     */
    function userCanDeleteAnProduct()
    {
        $product = $this->factory->create();

        $this->page->go_to_product_page($product);

        $this->page->click_on_delete();

        $this->assertNotContains(
            $product->getTitle(),
            $this->page->products_table(),
            'Product has been removed'
        );
    }

    private function now()
    {
        return new \Datetime();
    }
}
