<?php
/**
 * Created by PhpStorm.
 * User: Minas
 * Date: 1/21/2018
 * Time: 7:38 PM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Address
 * @package AppBundle\Entity
 * @ORM\Entity()
 * @ORM\Table(name="users_addresses")
 */
class Address
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="text", name="address")
     */
    protected $address;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="addresses")
     * @ORM\JoinColumn(name="user_id",nullable=false, referencedColumnName="id")
     */
    protected $user;

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
     * Set address
     *
     * @param string $address
     * @return Address
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     * @return Address
     */
    public function setUser(\AppBundle\Entity\User $user)
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
}
