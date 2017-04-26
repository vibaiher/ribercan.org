<?php

namespace Tests\Ribercan\Helper\Factory;

use Symfony\Component\HttpFoundation\File\UploadedFile;

use Ribercan\EventBundle\Entity\Event as EventEntity;
use Ribercan\EventBundle\Entity\EventImage;

class Event
{
    private $entity_manager;

    public function __construct($entity_manager)
    {
        $this->entity_manager = $entity_manager;
    }

    public function create(array $attributes = [])
    {
        $announcement = new EventEntity();

        $title = $this->extractFrom($attributes, 'title');
        $summary = $this->extractFrom($attributes, 'summary');
        $body = $this->extractFrom($attributes, 'body');
        $image = $this->extractFrom($attributes, 'image');
        $publishedAt = $this->extractFrom($attributes, 'publishedAt');

        $announcement->setTitle($title);
        $announcement->setSummary($summary);
        $announcement->setBody($body);
        $announcement->setUploadedImage($image);
        $announcement->setPublishedAt($publishedAt);

        $this->entity_manager->persist($announcement);
        $this->entity_manager->flush();

        return $announcement;
    }

    private function extractFrom($attributes, $field_name)
    {
        if (!isset($attributes[$field_name])) {
            return $this->defaults()[$field_name];
        }

        return $attributes[$field_name];
    }

    private function defaults()
    {
        $defaults = array(
            'title' => 'This is a title',
            'summary' => 'This is summary',
            'body' => '<p>This is a body, with <a href="/link">links</a></p>',
            'image' => $this->defaultImage(),
            'publishedAt' => new \DateTime()
        );

        return $defaults;
    }

    private function defaultImage()
    {
        $image_name = 'dog.jpg';
        $original_folder = __DIR__ . '/images';
        $destiny_folder = __DIR__ . '/../../../../var/tmp';

        if (!is_dir($destiny_folder)) {
            mkdir($destiny_folder);
        }

        copy("{$original_folder}/{$image_name}", "{$destiny_folder}/{$image_name}");

        $file_size = $error_level_code = null;
        $test_mode_on = true;

        $path = "{$destiny_folder}/{$image_name}";
        $image = new UploadedFile(
            $path,
            'dog.jpg',
            'image/jpg',
            $file_size,
            $error_level_code,
            $test_mode_on
        );
        return $image;
    }
}
