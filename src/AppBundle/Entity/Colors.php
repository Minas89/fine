<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Colors
 * @package AppBundle\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\ColorsRepository")
 * @ORM\Table(name="colors")
 */
class Colors
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
     * @ORM\Column(type="string", name="color")
     */
    protected $color;

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
     * @return Colors
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
     * @return Colors
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
     * @return Colors
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
     * Set color
     *
     * @param string $color
     * @return Colors
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string 
     */
    public function getColor()
    {
        return $this->color;
    }

    public function __toString()
    {
        return $this->getTitleEng();
    }
}
