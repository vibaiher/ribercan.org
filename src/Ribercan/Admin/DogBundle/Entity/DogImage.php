<?php

namespace Ribercan\Admin\DogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Ribercan\Admin\DogBundle\Entity\Dog;

/**
 * DogImage
 *
 * @ORM\Table(name="dog_images")
 * @ORM\Entity(repositoryClass="Ribercan\Admin\DogBundle\Repository\DogImageRepository")
 */
class DogImage
{
    /**
     * @var int
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
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255, nullable=true)
     */
    private $path;

    /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;

    /**
     * @var bool
     *
     * @ORM\Column(name="first_image", type="boolean", options={"default" = 0})
     */
    private $firstImage = false;

    /**
     * @ORM\ManyToOne(targetEntity="Dog", inversedBy="dogs")
     * @ORM\JoinColumn(name="dog_id", referencedColumnName="id")
     */
    protected $dog;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Image
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
     * Set path
     *
     * @param string $path
     *
     * @return Image
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set firstImage
     *
     * @param boolean $firstImage
     *
     * @return Image
     */
    public function setFirstImage($firstImage)
    {
        $this->firstImage = $firstImage;

        return $this;
    }

    /**
     * Get firstImage
     *
     * @return bool
     */
    public function getFirstImage()
    {
        return $this->firstImage;
    }

    /**
     * Set dog
     *
     * @param Dog $dog
     *
     * @return Image
     */
    public function setDog(Dog $dog = null)
    {
        $this->dog = $dog;

        return $this;
    }

    /**
     * Get dog
     *
     * @return Dog
     */
    public function getDog()
    {
        return $this->dog;
    }

    public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir().'/'.$this->path;
    }

    public function upload()
    {
        if (null === $this->getFile()) {
            return;
        }

        $this->getFile()->move(
            $this->getUploadRootDir(),
            $this->getFile()->getClientOriginalName()
        );

        $this->path = $this->getFile()->getClientOriginalName();

        $this->file = null;
    }

    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        return 'images/dogs';
    }
}
