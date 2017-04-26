<?php

namespace Ribercan\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Ribercan\EventBundle\Entity\EventImage;

/**
 * Event
 *
 * @ORM\Table(name="events")
 * @ORM\Entity(repositoryClass="Ribercan\EventBundle\Repository\Event")
 * @ORM\HasLifecycleCallbacks
 */
class Event
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
     */
    private $publishedAt;

    /**
     * @var EventImage
     *
     * @ORM\OneToOne(targetEntity="EventImage", mappedBy="event", cascade={"persist", "remove"})
     */
    private $image;

    /**
     * @var UploadedFile
     */
    private $uploadedImage;

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
     * @return Event
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
     * @return Event
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
     * @return Event
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
    public function setImage(EventImage $image)
    {
        $this->image = $image;
    }

    /**
     * Get image
     *
     * @return EventImage
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set publishedAt
     *
     * @param string $publishedAt
     * @return Event
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
            $event_image = new EventImage($this->uploadedImage);
            $event_image->setEvent($this);

            $this->setImage($event_image);

            unset($this->uploadedImage);
        }
    }
}
