<?php
/**
 * Created by PhpStorm.
 * User: minas
 * Date: 2/2/20
 * Time: 8:20 PM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class WishlistItem
 * @package AppBundle\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\WishlistItemRepository")
 * @ORM\Table(name="wishlist_items")
 * @ORM\HasLifecycleCallbacks()
 */
class WishlistItem
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Wishlist", inversedBy="items")
     * @ORM\JoinColumn(name="wishlist_id",referencedColumnName="id")
     */
    protected $wishlist;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Products")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    protected $product;

    /**
     * @ORM\Column(type="datetime", name="created")
     */
    protected $created;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $updated;

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
     * Set created
     *
     * @param \DateTime $created
     * @return WishlistItem
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
     * Set updated
     *
     * @param \DateTime $updated
     * @return WishlistItem
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set wishlist
     *
     * @param \AppBundle\Entity\Wishlist $wishlist
     * @return WishlistItem
     */
    public function setWishlist(\AppBundle\Entity\Wishlist $wishlist = null)
    {
        $this->wishlist = $wishlist;

        return $this;
    }

    /**
     * Get wishlist
     *
     * @return \AppBundle\Entity\Wishlist 
     */
    public function getWishlist()
    {
        return $this->wishlist;
    }

    /**
     * Set product
     *
     * @param \AppBundle\Entity\Products $product
     * @return WishlistItem
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
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
        $this->created = new \DateTime();
    }

    /**
     * @ORM\PreUpdate()
     */
    public function preUpdate()
    {
        $this->updated = new \DateTime();
    }
}
