<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class Wishlist
 * @package AppBundle\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\WishlistRepository")
 * @ORM\Table(name="wishlist_users")
 * @UniqueEntity(fields={"user","sess_id"})
 * @ORM\HasLifecycleCallbacks()
 */
class Wishlist
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", name="sess_id", nullable=true, unique=true)
     */
    protected $sessId;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\WishlistItem", mappedBy="wishlist")
     */
    protected $items;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="wishes")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

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
     * Set created
     *
     * @param \DateTime $created
     * @return Wishlist
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
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     * @return Wishlist
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }


    /**
     * Set sessId
     *
     * @param string $sessId
     * @return Wishlist
     */
    public function setSessId($sessId)
    {
        $this->sessId = $sessId;

        return $this;
    }

    /**
     * Get sessId
     *
     * @return string 
     */
    public function getSessId()
    {
        return $this->sessId;
    }

    /**
     * Add items
     *
     * @param \AppBundle\Entity\WishlistItem $items
     * @return Wishlist
     */
    public function addItem(\AppBundle\Entity\WishlistItem $items)
    {
        $this->items[] = $items;

        return $this;
    }

    /**
     * Remove items
     *
     * @param \AppBundle\Entity\WishlistItem $items
     */
    public function removeItem(\AppBundle\Entity\WishlistItem $items)
    {
        $this->items->removeElement($items);
    }

    /**
     * Get items
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getItems()
    {
        return $this->items;
    }
}
