<?php
/**
 * Created by PhpStorm.
 * User: Minas
 * Date: 10/22/2017
 * Time: 4:03 PM
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;


abstract class AbstractEntity
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", name="title_arm", nullable=true)
     */
    protected $titleArm;

    /**
     * @ORM\Column(type="string", name="title_rus", nullable=true)
     */
    protected $titleRus;

    /**
     * @ORM\Column(type="string", name="title_eng")
     */
    protected $titleEng;

    /**
     * @ORM\Column(type="text", name="text_arm", nullable=true)
     */
    protected $textArm;

    /**
     * @ORM\Column(type="text", name="text_rus", nullable=true)
     */
    protected $textRus;

    /**
     * @ORM\Column(type="text", name="text_eng", nullable=true)
     */
    protected $textEng;

    /**
     * @ORM\Column(type="string", name="slug", unique=true)
     */
    protected $slug;

    /**
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id")
     */
    protected $image;

    /**
     * @ORM\Column(type="integer", name="position")
     */
    protected $position = 1;

    /**
     * @ORM\Column(name="meta_keywords", type="string", nullable=true)
     */
    protected $metaKeywords;

    /**
     * @ORM\Column(type="string", name="meta_description", nullable=true)
     */
    protected $metaDescription;

    /**
     * @ORM\Column(type="datetime", name="created")
     */
    protected $created;


    public function __construct()
    {
        $this->created = new \DateTime();
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
     * Set titleArm
     *
     * @param string $titleArm
     * @return Categories
     */
    public function setTitleArm($titleArm)
    {
        $this->titleArm = $titleArm;

        return $this;
    }

    /**
     * Get titleArm
     *
     * @return string
     */
    public function getTitleArm()
    {
        return $this->titleArm;
    }

    /**
     * Set titleRus
     *
     * @param string $titleRus
     * @return Categories
     */
    public function setTitleRus($titleRus)
    {
        $this->titleRus = $titleRus;

        return $this;
    }

    /**
     * Get titleRus
     *
     * @return string
     */
    public function getTitleRus()
    {
        return $this->titleRus;
    }

    /**
     * Set titleEng
     *
     * @param string $titleEng
     * @return Categories
     */
    public function setTitleEng($titleEng)
    {
        $this->titleEng = $titleEng;

        return $this;
    }

    /**
     * Get titleEng
     *
     * @return string
     */
    public function getTitleEng()
    {
        return $this->titleEng;
    }

    /**
     * @return mixed
     */
    public function getTextArm()
    {
        return $this->textArm;
    }

    /**
     * @param mixed $textArm
     */
    public function setTextArm($textArm)
    {
        $this->textArm = $textArm;
    }

    /**
     * @return mixed
     */
    public function getTextRus()
    {
        return $this->textRus;
    }

    /**
     * @param mixed $textRus
     */
    public function setTextRus($textRus)
    {
        $this->textRus = $textRus;
    }

    /**
     * @return mixed
     */
    public function getTextEng()
    {
        return $this->textEng;
    }

    /**
     * @param mixed $textEng
     */
    public function setTextEng($textEng)
    {
        $this->textEng = $textEng;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Categories
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return Categories
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set metaKeywords
     *
     * @param string $metaKeywords
     * @return Categories
     */
    public function setMetaKeywords($metaKeywords)
    {
        $this->metaKeywords = $metaKeywords;

        return $this;
    }

    /**
     * Get metaKeywords
     *
     * @return string
     */
    public function getMetaKeywords()
    {
        return $this->metaKeywords;
    }

    /**
     * Set metaDescription
     *
     * @param string $metaDescription
     * @return Categories
     */
    public function setMetaDescription($metaDescription)
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }

    /**
     * Get metaDescription
     *
     * @return string
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
    }


    /**
     * Set image
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $image
     * @return Categories
     */
    public function setImage(\Application\Sonata\MediaBundle\Entity\Media $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \Application\Sonata\MediaBundle\Entity\Media
     */
    public function getImage()
    {
        return $this->image;
    }



    public function __toString()
    {
        return (string)$this->getTitleEng();
    }

}