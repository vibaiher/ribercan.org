<?php

namespace Tests\Ribercan\Helper\Factory;

use Symfony\Component\HttpFoundation\File\UploadedFile;

use Ribercan\ShopBundle\Entity\Product as ProductEntity;
use Ribercan\ShopBundle\Entity\ProductImage;

class Product
{
    private $entity_manager;

    public function __construct($entity_manager)
    {
        $this->entity_manager = $entity_manager;
    }

    public function create(array $attributes = [])
    {
        $product = new ProductEntity();

        $title = $this->extractFrom($attributes, 'title');
        $price = $this->extractFrom($attributes, 'price');
        $description = $this->extractFrom($attributes, 'description');
        $image = $this->extractFrom($attributes, 'image');
        $available = $this->extractFrom($attributes, 'available');

        $product->setTitle($title);
        $product->setPrice($price);
        $product->setDescription($description);
        $product->setUploadedImages([$image]);
        $product->setAvailable($available);

        $this->entity_manager->persist($product);
        $this->entity_manager->flush();

        return $product;
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
            'price' => 1.5,
            'description' => '<p>This is a description, with <a href="/link">links</a></p>',
            'image' => $this->defaultImage(),
            'available' => true
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
