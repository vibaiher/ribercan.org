<?php

namespace Ribercan\Admin\DogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Ribercan\Admin\DogBundle\Entity\DogImage;

/**
 * Dog
 *
 * @ORM\Table(name="dogs")
 * @ORM\Entity(repositoryClass="Ribercan\Admin\DogBundle\Repository\DogRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Dog
{
    const MALE = "0";
    const FEMALE = "1";

    const SMALL = "0";
    const MEDIUM = "1";
    const BIG = "2";

    const PUPPY = "0";
    const ADULT = "1";

    const NOT_STERILIZED_YET = "0";
    const STERILIZED = "1";

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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var boolean
     *
     * @ORM\Column(name="sex", type="boolean", options={"default":false})
     */
    private $sex;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthday", type="datetime")
     */
    private $birthday;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="join_date", type="datetime")
     */
    private $joinDate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="sterilized", type="boolean")
     */
    private $sterilized;

    /**
     * @var string
     *
     * @ORM\Column(name="health", type="text", nullable=true)
     */
    private $health;

    /**
     * @var string
     *
     * @ORM\Column(name="godfather", type="string", length=255, nullable=true)
     */
    private $godfather;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="size", type="string", length=255)
     */
    private $size;

    /**
     * @var boolean
     *
     * @ORM\Column(name="urgent", type="boolean", options={"default":false})
     */
    private $urgent;

    /**
     * @var string
     *
     * @ORM\Column(name="video", type="string", length=255, nullable=true)
     */
    private $video;

    /**
     * @ORM\OneToMany(targetEntity="DogImage", mappedBy="dog", cascade={"persist", "remove"})
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
     * Set name
     *
     * @param string $name
     * @return Dog
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set sex
     *
     * @param boolean $sex
     * @return Dog
     */
    public function setSex($sex)
    {
        $this->sex = $sex;

        return $this;
    }

    /**
     * Get sex
     *
     * @return boolean
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * Set birthday
     *
     * @param \DateTime $birthday
     * @return Dog
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday
     *
     * @return \DateTime
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set joinDate
     *
     * @param \DateTime $joinDate
     * @return Dog
     */
    public function setJoinDate($joinDate)
    {
        $this->joinDate = $joinDate;

        return $this;
    }

    /**
     * Get joinDate
     *
     * @return \DateTime
     */
    public function getJoinDate()
    {
        return $this->joinDate;
    }

    /**
     * Set sterilized
     *
     * @param string $sterilized
     * @return Dog
     */
    public function setSterilized($sterilized)
    {
        $this->sterilized = $sterilized;

        return $this;
    }

    /**
     * Get sterilized
     *
     * @return string
     */
    public function getSterilized()
    {
        return $this->sterilized;
    }

    /**
     * Set health
     *
     * @param string $health
     * @return Dog
     */
    public function setHealth($health)
    {
        $this->health = $health;

        return $this;
    }

    /**
     * Get health
     *
     * @return string
     */
    public function getHealth()
    {
        return $this->health;
    }

    /**
     * Set godfather
     *
     * @param string $godfather
     * @return Dog
     */
    public function setGodfather($godfather)
    {
        $this->godfather = $godfather;

        return $this;
    }

    /**
     * Get godfather
     *
     * @return string
     */
    public function getGodfather()
    {
        return $this->godfather;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Dog
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
     * Set size
     *
     * @param string $size
     * @return Dog
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set urgent
     *
     * @param string $urgent
     * @return Dog
     */
    public function setUrgent($urgent)
    {
        $this->urgent = $urgent;

        return $this;
    }

    /**
     * Get urgent
     *
     * @return string
     */
    public function getUrgent()
    {
        return $this->urgent;
    }

    /**
     * Set video
     *
     * @param string $video
     * @return Dog
     */
    public function setVideo($video)
    {
        $this->video = $video;

        return $this;
    }

    /**
     * Get video
     *
     * @return string
     */
    public function getVideo()
    {
        return $this->video;
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
     * Get main image
     *
     * @return DogImage
     */
    public function getMainImage()
    {
        if (empty($this->images) || !isset($this->images[0])) {
            return null;
        }

        foreach ($this->images as $image) {
            if ($image->getFirstImage() == true) {
                return $image;
            }
        }

        return $this->images[0];
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
                $dogImage = new DogImage($uploadedImage);
                $dogImage->setDog($this);
                $dogImage->setFirstImage(false);

                $this->getImages()->add($dogImage);

                unset($uploadedImage);
            }
        }
    }
}
