<?php

namespace Ribercan\NewsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Ribercan\NewsBundle\Entity\AnnouncementImage;

/**
 * Announcement
 *
 * @ORM\Table(name="news")
 * @ORM\Entity(repositoryClass="Ribercan\NewsBundle\Repository\News")
 * @ORM\HasLifecycleCallbacks
 */
class Announcement
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
     * @ORM\Column(name="summary", type="text", options={"default":false})
     * @Assert\NotBlank
     */
    private $summary;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="text", options={"default":false})
     * @Assert\NotBlank
     */
    private $body;

    /**
     * @var string
     *
     * @ORM\Column(name="published_at", type="datetime")
     * @Assert\NotBlank
     */
    private $publishedAt;

    /**
     * @ORM\OneToOne(targetEntity="AnnouncementImage", mappedBy="announcement", cascade={"persist", "remove"})
     */
    private $image;

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
     * @return Announcement
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
     * Set summary
     *
     * @param string $summary
     * @return Announcement
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * Get summary
     *
     * @return string
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * Set body
     *
     * @param string $body
     * @return Announcement
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set image
     */
    public function setImage(AnnouncementImage $image)
    {
        $this->image = $image;
    }

    /**
     * Get image
     *
     * @return AnnouncementImage
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set publishedAt
     *
     * @param string $publishedAt
     * @return Announcement
     */
    public function setPublishedAt($publishedAt)
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    /**
     * Get publishedAt
     *
     * @return string
     */
    public function getPublishedAt()
    {
        return $this->publishedAt;
    }

    /**
     * @return UploadedFile
     */
    public function getUploadedImage()
    {
        return $this->uploadedImage;
    }

    /**
     * @param UploadedFile $uploadedImage
     */
    public function setUploadedImage(UploadedFile $uploadedImage)
    {
        $this->uploadedImage = $uploadedImage;
    }

    /**
     * @ORM\PreFlush()
     */
    public function publish()
    {
        if (is_null($this->getPublishedAt()))
        {
            $this->setPublishedAt(new \DateTime());
        }
    }

    /**
     * @ORM\PreFlush()
     */
    public function upload()
    {
        if (isset($this->uploadedImage)) {
            $announcement_image = new AnnouncementImage($this->uploadedImage);
            $announcement_image->setAnnouncement($this);

            $this->setImage($announcement_image);

            unset($this->uploadedImage);
        }
    }
}
