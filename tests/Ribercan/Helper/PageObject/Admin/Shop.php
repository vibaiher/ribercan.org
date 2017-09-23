<?php

namespace Tests\Ribercan\Helper\PageObject\Admin;

use Symfony\Component\HttpFoundation\File\UploadedFile;

use Ribercan\ShopBundle\Entity\Product;
use Tests\Ribercan\Helper\PageObject\PageObject;

class Shop extends PageObject
{
    const ADD_PRODUCT_PAGE_TITLE = 'Añadir un producto';
    const EDIT_PRODUCT_PAGE_TITLE = 'Editar un producto';

    private $form_data;

    public function __construct($client, $crawler = null)
    {
        $this->form_data = array();
        parent::__construct($client, $crawler);
    }

    public function go_to_new_product_page()
    {
        $this->crawler = $this->client->request('GET', '/admin');
        $link = $this->crawler->filter('a:contains("Tienda")')->link();
        $this->crawler = $this->client->click($link);
        $link = $this->crawler->filter('a:contains("Añadir un producto")')->link();
        $this->crawler = $this->client->click($link);

        if ($this->page_title() != self::ADD_PRODUCT_PAGE_TITLE) {
            throw new \Exception("Add product page is not accesible");
        }
    }

    public function go_to_product_page(Product $product)
    {
        $this->crawler = $this->client->request('GET', '/admin');
        $link = $this->crawler->filter('a:contains("Tienda")')->link();
        $this->crawler = $this->client->click($link);
        $link = $this->crawler->filter("a[href=\"/admin/products/{$product->getId()}/show\"]")->link();
        $this->crawler = $this->client->click($link);


        if ($this->product_title() != $product->getTitle()) {
            throw new \Exception("Product <{$product->getId()}> page is not accesible");
        }
    }

    public function go_to_edit_product_page(Product $product)
    {
        $this->crawler = $this->client->request('GET', '/admin');
        $link = $this->crawler->filter('a:contains("Tienda")')->link();
        $this->crawler = $this->client->click($link);
        $link = $this->crawler->filter("a[href=\"/admin/products/{$product->getId()}/edit\"]")->link();
        $this->crawler = $this->client->click($link);


        if ($this->page_title() != self::EDIT_PRODUCT_PAGE_TITLE) {
            throw new \Exception("Edit product <{$product->getId()}> page is not accesible");
        }
    }

    public function fill_title_with($title)
    {
        $this->form_data['product[title]'] = $title;
    }

    public function fill_price_with($price)
    {
        $this->form_data['product[price]'] = $price;
    }

    public function fill_description_with($description)
    {
        $this->form_data['product[description]'] = $description;
    }

    public function upload_image($name)
    {
        $folder = __DIR__ . '/../../../Helper/Images';

        $uploaded_image = new UploadedFile(
            "{$folder}/{$name}",
            $name
        );

        $this->form_data['product[uploadedImages][0]'] = $uploaded_image;
    }

    public function click_on_publish()
    {
        $this->submit_button('Publish');
    }

    public function click_on_update()
    {
        $this->submit_button('Update');
    }

    public function click_on_delete()
    {
        $form = $this->crawler->
            selectButton('Delete')->
            form();

        $this->client->submit($form);
        $this->crawler = $this->client->followRedirect();
    }

    public function products_table()
    {
        return $this->crawler->
            filter('table.table')->
            html();
    }

    public function product_title()
    {
        return $this->crawler->
            filter('#product_title')->
            text();
    }

    public function product_price()
    {
        return $this->crawler->
            filter('#product_price')->
            text();
    }

    public function product_description()
    {
        return $this->crawler->
            filter('#product_description')->
            html();
    }

    public function product_image()
    {
        return $this->crawler->
            filter('#product_image_1')->
            attr('alt');
    }

    public function product_published_at()
    {
        return $this->crawler->
            filter('#product_published_at')->
            text();
    }

    private function page_title()
    {
        return $this->crawler->
            filter('h1')->
            text();
    }

    private function submit_button($button)
    {
        $form = $this->crawler->
            selectButton($button)->
            form($this->form_data);

        $this->client->submit($form);
        $this->crawler = $this->client->followRedirect();
    }
}
