<?php
/**
 * Created by PhpStorm.
 * User: minas
 * Date: 7/16/20
 * Time: 11:04 PM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Style
 * @package AppBundle\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\ShippingRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Shipping extends AbstractEntity
{
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Products", mappedBy="shipping")
     */
    protected $products;
   

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Shipping
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
     * Add products
     *
     * @param \AppBundle\Entity\Products $products
     * @return Shipping
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
}
