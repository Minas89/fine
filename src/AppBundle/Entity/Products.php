<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\AbstractEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * Class Products
 * @package AppBundle\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\ProductsRepository")
 * @ORM\Table(name="products")
 * @UniqueEntity("slug")
 * @ORM\HasLifecycleCallbacks()
 */
class Products extends AbstractEntity
{
    const newArrivals = 20;
    const TOP_CAROUSEL_LIMIT = 16;

    /**
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Gallery", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="gallery_id", referencedColumnName="id")
     */
    protected $gallery;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Categories", inversedBy="products")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    protected $category;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ProductDetails", mappedBy="product", cascade={"persist", "remove"},orphanRemoval=true)
     */
    protected $details;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Creators", inversedBy="products")
     * @ORM\JoinColumn(name="creator_id", referencedColumnName="id")
     */
    protected $creator;

    /**
     * @ORM\Column(type="integer", nullable=true, name="year")
     */
    protected $year;

    /**
     * @ORM\Column(type="boolean", name="new")
     */
    protected $new = false;

    /**
     * @ORM\Column(type="float", name="price", nullable=true)
     */
    protected $price;

    /**
     * @ORM\Column(type="boolean", name="top", nullable=true)
     */
    protected $top = false;

    /**
     * @ORM\Column(type="boolean", name="sale")
     */
    protected $sale = false;

    /**
     * @ORM\Column(type="string", name="ref_id", nullable=true)
     */
    protected $refId;

    /**
     * @ORM\Column(type="float", name="sale_percent", nullable=true)
     */
    protected $salePercent;


    /**
     * Many Products have Many Colors.
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Colors")
     * @ORM\JoinTable(name="products_colors",
     *      joinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="color_id", referencedColumnName="id")}
     *      )
     */
    protected $colors;

    /**
     * @ORM\Column(type="integer", name="width", nullable=true)
     */
    protected $width;

    /**
     * @ORM\Column(type="integer", name="height", nullable=true)
     */
    protected $height;

    /**
     * @ORM\ManyToOne(targetEntity="Style", inversedBy="products")
     */
    protected $style;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Shipping", inversedBy="products")
     */
    protected $shipping;

    /**
     * Set gallery
     *
     * @param \Application\Sonata\MediaBundle\Entity\Gallery $gallery
     * @return Products
     */
    public function setGallery(\Application\Sonata\MediaBundle\Entity\Gallery $gallery = null)
    {
        $this->gallery = $gallery;

        return $this;
    }

    /**
     * Get gallery
     *
     * @return \Application\Sonata\MediaBundle\Entity\Gallery 
     */
    public function getGallery()
    {
        return $this->gallery;
    }

    /**
     * Set category
     *
     * @param \AppBundle\Entity\Categories $category
     * @return Products
     */
    public function setCategory(\AppBundle\Entity\Categories $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Categories 
     */
    public function getCategory()
    {
        return $this->category;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->details = new ArrayCollection();
        $this->colors = new ArrayCollection();

        $sixDigit = mt_rand(10000000,99999999);
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $length = 2;

        $randomletter = substr(str_shuffle($characters), 0, $length);

        $this->refId = $randomletter.$sixDigit;

    }

    /**
     * Add details
     *
     * @param \AppBundle\Entity\ProductDetails $details
     * @return Products
     */
    public function addDetail(\AppBundle\Entity\ProductDetails $details)
    {
        $this->details[] = $details;
        $details->setProduct($this);
        return $this;
    }

    /**
     * Remove details
     *
     * @param \AppBundle\Entity\ProductDetails $details
     */
    public function removeDetail(\AppBundle\Entity\ProductDetails $details)
    {
        $this->details->removeElement($details);
    }

    /**
     * Get details
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * Set creator
     *
     * @param \AppBundle\Entity\Creators $creator
     * @return Products
     */
    public function setCreator(\AppBundle\Entity\Creators $creator = null)
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * Get creator
     *
     * @return \AppBundle\Entity\Creators 
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * Set year
     *
     * @param integer $year
     * @return Products
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return integer 
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set creted
     *
     * @param \DateTime $creted
     * @return Products
     */
    public function setCreted($creted)
    {
        $this->creted = $creted;

        return $this;
    }

    /**
     * Get creted
     *
     * @return \DateTime 
     */
    public function getCreted()
    {
        return $this->creted;
    }

    /**
     * Set new
     *
     * @param boolean $new
     * @return Products
     */
    public function setNew($new)
    {
        $this->new = $new;

        return $this;
    }

    /**
     * Get new
     *
     * @return boolean 
     */
    public function getNew()
    {
        return $this->new;
    }

    /**
     * Set price
     *
     * @param float $price
     * @return Products
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set top
     *
     * @param boolean $top
     * @return Products
     */
    public function setTop($top)
    {
        $this->top = $top;

        return $this;
    }

    /**
     * Get top
     *
     * @return boolean 
     */
    public function getTop()
    {
        return $this->top;
    }

    /**
     * Set sale
     *
     * @param boolean $sale
     * @return Products
     */
    public function setSale($sale)
    {
        $this->sale = $sale;

        return $this;
    }

    /**
     * Get sale
     *
     * @return boolean 
     */
    public function getSale()
    {
        return $this->sale;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Products
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Add colors
     *
     * @param \AppBundle\Entity\Colors $colors
     * @return Products
     */
    public function addColor(\AppBundle\Entity\Colors $colors)
    {
        $this->colors[] = $colors;

        return $this;
    }

    /**
     * Remove colors
     *
     * @param \AppBundle\Entity\Colors $colors
     */
    public function removeColor(\AppBundle\Entity\Colors $colors)
    {
        $this->colors->removeElement($colors);
    }

    /**
     * Get colors
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getColors()
    {
        return $this->colors;
    }



    /**
     * Set refId
     *
     * @param string $refId
     * @return Products
     */
    public function setRefId($refId)
    {
        $this->refId = $refId;

        return $this;
    }

    /**
     * Get refId
     *
     * @return string 
     */
    public function getRefId()
    {
        return $this->refId;
    }

    /**
     * Set width
     *
     * @param integer $width
     * @return Products
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get width
     *
     * @return integer 
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set height
     *
     * @param integer $height
     * @return Products
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get height
     *
     * @return integer 
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set salePercent
     *
     * @param float $salePercent
     * @return Products
     */
    public function setSalePercent($salePercent)
    {
        $this->salePercent = $salePercent;

        return $this;
    }

    /**
     * Get salePercent
     *
     * @return float 
     */
    public function getSalePercent()
    {
        return $this->salePercent;
    }

    /**
     * Set style
     *
     * @param \AppBundle\Entity\Style $style
     * @return Products
     */
    public function setStyle(\AppBundle\Entity\Style $style = null)
    {
        $this->style = $style;

        return $this;
    }

    /**
     * Get style
     *
     * @return \AppBundle\Entity\Style 
     */
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * Set shipping
     *
     * @param \AppBundle\Entity\Shipping $shipping
     * @return Products
     */
    public function setShipping(\AppBundle\Entity\Shipping $shipping = null)
    {
        $this->shipping = $shipping;

        return $this;
    }

    /**
     * Get shipping
     *
     * @return \AppBundle\Entity\Shipping 
     */
    public function getShipping()
    {
        return $this->shipping;
    }
}
