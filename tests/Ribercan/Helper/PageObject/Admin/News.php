<?php

namespace Tests\Ribercan\Helper\PageObject\Admin;

use Symfony\Component\HttpFoundation\File\UploadedFile;

use Ribercan\NewsBundle\Entity\Announcement;
use Tests\Ribercan\Helper\PageObject\PageObject;

class News extends PageObject
{
    const ADD_ANNOUNCEMENT_PAGE_TITLE = 'Añadir una notícia';
    const EDIT_ANNOUNCEMENT_PAGE_TITLE = 'Editar una notícia';

    private $form_data;

    public function __construct($client, $crawler = null)
    {
        $this->form_data = array();
        parent::__construct($client, $crawler);
    }

    public function go_to_new_announcement_page()
    {
        $this->crawler = $this->client->request('GET', '/admin');
        $link = $this->crawler->filter('a:contains("Notícias")')->link();
        $this->crawler = $this->client->click($link);
        $link = $this->crawler->filter('a:contains("Añadir una notícia")')->link();
        $this->crawler = $this->client->click($link);


        if ($this->page_title() != self::ADD_ANNOUNCEMENT_PAGE_TITLE) {
            throw new \Exception("Add announcement page is not accesible");
        }
    }

    public function go_to_announcement_page(Announcement $announcement)
    {
        $this->crawler = $this->client->request('GET', '/admin');
        $link = $this->crawler->filter('a:contains("Notícias")')->link();
        $this->crawler = $this->client->click($link);
        $link = $this->crawler->filter("a[href=\"/admin/news/{$announcement->getId()}/show\"]")->link();
        $this->crawler = $this->client->click($link);


        if ($this->announcement_title() != $announcement->getTitle()) {
            throw new \Exception("Announcement <{$announcement->getId()}> page is not accesible");
        }
    }

    public function go_to_edit_announcement_page(Announcement $announcement)
    {
        $this->crawler = $this->client->request('GET', '/admin');
        $link = $this->crawler->filter('a:contains("Notícias")')->link();
        $this->crawler = $this->client->click($link);
        $link = $this->crawler->filter("a[href=\"/admin/news/{$announcement->getId()}/edit\"]")->link();
        $this->crawler = $this->client->click($link);


        if ($this->page_title() != self::EDIT_ANNOUNCEMENT_PAGE_TITLE) {
            throw new \Exception("Edit announcement <{$announcement->getId()}> page is not accesible");
        }
    }

    public function fill_title_with($title)
    {
        $this->form_data['announcement[title]'] = $title;
    }

    public function fill_summary_with($summary)
    {
        $this->form_data['announcement[summary]'] = $summary;
    }

    public function fill_body_with($body)
    {
        $this->form_data['announcement[body]'] = $body;
    }

    public function upload_image($name)
    {
        $folder = __DIR__ . '/../../../Helper/Images';

        $uploaded_image = new UploadedFile(
            "{$folder}/{$name}",
            $name
        );

        $this->form_data['announcement[uploadedImage]'] = $uploaded_image;
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

    public function news_table()
    {
        return $this->crawler->
            filter('table.table')->
            html();
    }

    public function announcement_title()
    {
        return $this->crawler->
            filter('#announcement_title')->
            text();
    }

    public function announcement_summary()
    {
        return $this->crawler->
            filter('#announcement_summary')->
            text();
    }

    public function announcement_body()
    {
        return $this->crawler->
            filter('#announcement_body')->
            html();
    }

    public function announcement_image()
    {
        return $this->crawler->
            filter('#announcement_image')->
            attr('alt');
    }

    public function announcement_published_at()
    {
        return $this->crawler->
            filter('#announcement_published_at')->
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