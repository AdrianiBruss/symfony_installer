<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Image
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ImageRepository")
 * @ORM\HasLifeCycleCallbacks()
 */
class Image
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
     * @ORM\Column(name="filename", type="string", length=255)
     */
    private $filename;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="filesize", type="integer")
     */
    private $filesize;

    /**
     * @var string
     *
     * @ORM\Column(name="mimeType", type="string", length=255)
     */
    private $mimeType;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreated", type="datetime")
     */
    private $dateCreated;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateModified", type="datetime")
     */
    private $dateModified;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isPublished", type="boolean")
     */
    private $isPublished;

    /**
     * @Assert\Image(
     *  maxSize="1024k"
     * )
     */
    private $tempFile;

    /**
     * @return mixed
     */
    public function getTempFile()
    {
        return $this->tempFile;
    }

    /**
     * @param mixed $tempFile
     */
    public function setTempFile($tempFile)
    {
        $this->tempFile = $tempFile;
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
     * Set filename
     *
     * @param string $filename
     * @return Image
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get filename
     *
     * @return string 
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Image
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
     * @return Image
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
     * Set filesize
     *
     * @param integer $filesize
     * @return Image
     */
    public function setFilesize($filesize)
    {
        $this->filesize = $filesize;

        return $this;
    }

    /**
     * Get filesize
     *
     * @return integer 
     */
    public function getFilesize()
    {
        return $this->filesize;
    }

    /**
     * Set mimeType
     *
     * @param string $mimeType
     * @return Image
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    /**
     * Get mimeType
     *
     * @return string 
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     * @return Image
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime 
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Set dateModified
     *
     * @param \DateTime $dateModified
     * @return Image
     */
    public function setDateModified($dateModified)
    {
        $this->dateModified = $dateModified;

        return $this;
    }

    /**
     * Get dateModified
     *
     * @return \DateTime 
     */
    public function getDateModified()
    {
        return $this->dateModified;
    }

    /**
     * Set isPublished
     *
     * @param boolean $isPublished
     * @return Image
     */
    public function setIsPublished($isPublished)
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    /**
     * Get isPublished
     *
     * @return boolean 
     */
    public function getIsPublished()
    {
        return $this->isPublished;
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersist(){


        $this->setFilename(
            sha1($this->getTempFile()->getClientOriginalName() )
            .uniqid()
            . '.' . $this->getTempFile()->guessExtension()
        );

        $this->setFilesize(
            $this->getTempFile()->getSize()
        );

        $this->setMimeType(
            $this->getTempFile()->getMimeType()
        );

        $this->setDateCreated(new DateTime());
        $this->setDateModified(new DateTime());
        $this->setIsPublished(true);

        $this->getTempFile()->move($this->getPathToOriginal(), $this->getFilename());

    }

    public function getPathToOriginal(){
        return $this->getPathToUploads()."originals";
    }

    public function getPathToMedium(){
        return $this->getPathToUploads()."medium";
    }

    public function getPathToThumbnail(){
        return $this->getPathToUploads()."thumbnail";
    }

    function getPathToUploads(){
        return __DIR__."/../../../web/uploads/";
    }
}
