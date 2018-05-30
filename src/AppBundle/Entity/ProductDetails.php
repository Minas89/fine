<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class ProductDetails
 * @package AppBundle\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\ProductsDetailsRepository")
 * @ORM\Table(name="product_details")
 */
class ProductDetails
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
     * @ORM\Column(type="string", name="value_arm", nullable=true)
     */
    protected $valueArm;

    /**
     * @ORM\Column(type="string", name="value_rus", nullable=true)
     */
    protected $valueRus;

    /**
     * @ORM\Column(type="string", name="value__eng")
     */
    protected $valueEng;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Products", inversedBy="details")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $product;
    
    /**
     * @ORM\Column(type="integer", name="position")
     */
    protected $position = 1;


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
     * @return ProductDetails
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
     * @return ProductDetails
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
     * @return ProductDetails
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
     * Set valueArm
     *
     * @param string $valueArm
     * @return ProductDetails
     */
    public function setValueArm($valueArm)
    {
        $this->valueArm = $valueArm;

        return $this;
    }

    /**
     * Get valueArm
     *
     * @return string 
     */
    public function getValueArm()
    {
        return $this->valueArm;
    }

    /**
     * Set valueRus
     *
     * @param string $valueRus
     * @return ProductDetails
     */
    public function setValueRus($valueRus)
    {
        $this->valueRus = $valueRus;

        return $this;
    }

    /**
     * Get valueRus
     *
     * @return string 
     */
    public function getValueRus()
    {
        return $this->valueRus;
    }

    /**
     * Set valueEng
     *
     * @param string $valueEng
     * @return ProductDetails
     */
    public function setValueEng($valueEng)
    {
        $this->valueEng = $valueEng;

        return $this;
    }

    /**
     * Get valueEng
     *
     * @return string 
     */
    public function getValueEng()
    {
        return $this->valueEng;
    }

    /**
     * Set product
     *
     * @param \AppBundle\Entity\Products $product
     * @return ProductDetails
     */
    public function setProduct(\AppBundle\Entity\Products $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \AppBundle\Entity\Products 
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return ProductDetails
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
}
