<?php

namespace Tests\Ribercan\Helper\PageObject\Admin;

use Symfony\Component\HttpFoundation\File\UploadedFile;

use Tests\Ribercan\Helper\PageObject\PageObject;

class News extends PageObject
{
    const NEWS_PAGE_TITLE = 'Añadir una notícia';

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


        if ($this->page_title() != self::NEWS_PAGE_TITLE) {
            throw new \Exception("News page is not accesible");
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

    public function submit_announcement()
    {
        $form = $this->crawler->
            selectButton('Publish')->
            form($this->form_data);

        $this->client->submit($form);
        $this->crawler = $this->client->followRedirect();
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
}