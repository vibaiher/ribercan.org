<?php

namespace Ribercan\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Ribercan\ShopBundle\Entity\ProductImage;

/**
 * Product
 *
 * @ORM\Table(name="products")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Product
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     * @Assert\NotBlank
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", options={"default":false})
     * @Assert\NotBlank
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="float", options={"default":0.0})
     */
    private $price;

    /**
     * @ORM\OneToMany(targetEntity="ProductImage", mappedBy="product", cascade={"persist", "remove"})
     */
    private $images;

    /**
     * @var ArrayCollection
     */
    private $uploadedImages;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->uploadedImages = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Product
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set price
     *
     * @param float $price
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Set images
     */
    public function setImages(array $images)
    {
        $this->images = $images;
    }

    /**
     * @return ArrayCollection
     */
    public function getUploadedImages()
    {
        return $this->uploadedImages;
    }

    /**
     * @param ArrayCollection $uploadedImages
     */
    public function setUploadedImages($uploadedImages)
    {
        $this->uploadedImages = $uploadedImages;
    }

    /**
     * @ORM\PreFlush()
     */
    public function upload()
    {
        foreach($this->uploadedImages as $uploadedImage)
        {
            if ($uploadedImage) {
                $productImage = new ProductImage($uploadedImage);
                $productImage->setProduct($this);

                $this->getImages()->add($productImage);

                unset($uploadedImage);
            }
        }
    }
}
