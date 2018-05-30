<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use AppBundle\Entity\AbstractEntity;

/**
 * Class Categories
 * @package AppBundle\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\CategoriesRepository")
 * @ORM\Table(name="categories")
 * @UniqueEntity("slug")
 * @ORM\HasLifecycleCallbacks()
 */
class Categories extends AbstractEntity
{
    const ArtistType = 1;
    const CreatorType = 2;
    const DesignerType = 3;

    const SHOP_BY_LIMIT = 16;

    /**
     * @ORM\OneToMany(targetEntity="Categories", mappedBy="parent")
     */
    protected $children;

    /**
     * @ORM\ManyToOne(targetEntity="Categories", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id",nullable=true, onDelete="SET NULL")
     */
    protected $parent;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Products", mappedBy="category")
     */
    protected $products;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Creators", mappedBy="category")
     */
    protected $creators;

    /**
     * @ORM\Column(type="integer", nullable=true, name="type")
     */
    protected $type;

    /**
     * @ORM\Column(type="boolean", name="shop_by" )
     */
    protected $shopBy = 0;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->children = new ArrayCollection();
        $this->products = new ArrayCollection();
        $this->creators = new ArrayCollection();
    }


    /**
     * Add children
     *
     * @param \AppBundle\Entity\Categories $children
     * @return Categories
     */
    public function addChild(\AppBundle\Entity\Categories $children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param \AppBundle\Entity\Categories $children
     */
    public function removeChild(\AppBundle\Entity\Categories $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set parent
     *
     * @param \AppBundle\Entity\Categories $parent
     * @return Categories
     */
    public function setParent(\AppBundle\Entity\Categories $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \AppBundle\Entity\Categories 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add products
     *
     * @param \AppBundle\Entity\Products $products
     * @return Categories
     */
    public function addProduct(\AppBundle\Entity\Products $products)
    {
        $this->products[] = $products;

        return $this;
    }

    /**
     * Remove products
     *
     * @param \AppBundle\Entity\Products $products
     */
    public function removeProduct(\AppBundle\Entity\Products $products)
    {
        $this->products->removeElement($products);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProducts()
    {
        return $this->products;
    }




    /**
     * Add creators
     *
     * @param \AppBundle\Entity\Creators $creators
     * @return Categories
     */
    public function addCreator(\AppBundle\Entity\Creators $creators)
    {
        $this->creators[] = $creators;

        return $this;
    }

    /**
     * Remove creators
     *
     * @param \AppBundle\Entity\Creators $creators
     */
    public function removeCreator(\AppBundle\Entity\Creators $creators)
    {
        $this->creators->removeElement($creators);
    }

    /**
     * Get creators
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCreators()
    {
        return $this->creators;
    }

    /**
     * Set creted
     *
     * @param \DateTime $creted
     * @return Categories
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
     * Set type
     *
     * @param integer $type
     * @return Categories
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Categories
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
     * Set shopBy
     *
     * @param boolean $shopBy
     * @return Categories
     */
    public function setShopBy($shopBy)
    {
        $this->shopBy = $shopBy;

        return $this;
    }

    /**
     * Get shopBy
     *
     * @return boolean 
     */
    public function getShopBy()
    {
        return $this->shopBy;
    }
}
