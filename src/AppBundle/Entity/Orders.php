<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class Orders
 * @package AppBundle\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\OrdersRepository")
 * @ORM\Table(name="orders")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity("orderNumber")
 */
class Orders
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer", name="order_number")
     */
    protected $orderNumber;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="orders")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Address")
     * @ORM\JoinColumn(name="user_address_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    protected $userAddress;

    /**
     * @ORM\Column(type="datetime", name="created")
     */
    protected $created;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\OrderItems", mappedBy="order")
     */
    protected $orderItems;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\OrderStatuses")
     * @ORM\JoinColumn(name="status_id",referencedColumnName="id")
     */
    protected $status;

    /**
     * @ORM\Column(type="float", name="total", nullable=true)
     */
    protected $total;

    public function __construct()
    {
        $this->created = new \DateTime();
        $this->orderItems = new ArrayCollection();
        $this->orderNumber = sprintf("%06d", mt_rand(1, 999999));
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
     * Set orderNumber
     *
     * @param integer $orderNumber
     * @return Orders
     */
    public function setOrderNumber($orderNumber)
    {
        $this->orderNumber = $orderNumber;

        return $this;
    }

    /**
     * Get orderNumber
     *
     * @return integer 
     */
    public function getOrderNumber()
    {
        return $this->orderNumber;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Orders
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
     * @return Orders
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
     * Set userAddress
     *
     * @param \AppBundle\Entity\Address $userAddress
     * @return Orders
     */
    public function setUserAddress(\AppBundle\Entity\Address $userAddress = null)
    {
        $this->userAddress = $userAddress;

        return $this;
    }

    /**
     * Get userAddress
     *
     * @return \AppBundle\Entity\Address 
     */
    public function getUserAddress()
    {
        return $this->userAddress;
    }

    /**
     * Add orderItems
     *
     * @param \AppBundle\Entity\OrderItems $orderItems
     * @return Orders
     */
    public function addOrderItem(\AppBundle\Entity\OrderItems $orderItems)
    {
        $this->orderItems[] = $orderItems;

        return $this;
    }

    /**
     * Remove orderItems
     *
     * @param \AppBundle\Entity\OrderItems $orderItems
     */
    public function removeOrderItem(\AppBundle\Entity\OrderItems $orderItems)
    {
        $this->orderItems->removeElement($orderItems);
    }

    /**
     * Get orderItems
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOrderItems()
    {
        return $this->orderItems;
    }

    /**
     * Set status
     *
     * @param \AppBundle\Entity\OrderStatuses $status
     * @return Orders
     */
    public function setStatus(\AppBundle\Entity\OrderStatuses $status = null)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return \AppBundle\Entity\OrderStatuses 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set total
     *
     * @param float $total
     * @return Orders
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return float 
     */
    public function getTotal()
    {
        return $this->total;
    }

    public function __toString()
    {
        return 'Order N'.$this->orderNumber;
    }
}
