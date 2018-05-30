<?php
/**
 * Created by PhpStorm.
 * User: Minas
 * Date: 10/22/2017
 * Time: 5:23 PM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\AbstractEntity;

/**
 * Class Creators
 * @package AppBundle\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\CreatorsRepository")
 * @ORM\Table(name="craetor_artists")
 * @ORM\HasLifecycleCallbacks()
 */
class Creators extends AbstractEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Categories", inversedBy="creators")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    protected $category;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Products", mappedBy="creator")
     */
    protected $products;


    /**
     * Set category
     *
     * @param \AppBundle\Entity\Categories $category
     * @return Creators
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
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add products
     *
     * @param \AppBundle\Entity\Products $products
     * @return Creators
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
     * Set creted
     *
     * @param \DateTime $creted
     * @return Creators
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
     * Set created
     *
     * @param \DateTime $created
     * @return Creators
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
}
