<?php
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\UserRepository")
 * @ORM\Table(name="users")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", name="firstname", nullable=true)
     */
    protected $firstname;

    /**
     * @ORM\Column(type="string", name="lastname", nullable=true)
     */
    protected $lastname;

    /**
     * @ORM\Column(type="string", name="title", nullable=true)
     */
    protected $title;

    /**
     * @ORM\Column(type="bigint", name="phone", nullable=true)
     */
    protected $phone;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Address", mappedBy="user")
     */
    protected $addresses;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Orders", mappedBy="user")
     */
    protected $orders;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Wishlist", mappedBy="user")
     */
    protected $wishes;

    /**
     * @ORM\Column(type="date", name="date_of_birth", nullable=true)
     */
    protected $dateOfBirth;

    /**
     * @ORM\Column(type="string", name="gender", nullable=true)
     */
    protected $gender;

    public function __construct()
    {
        parent::__construct();
        $this->addresses = new ArrayCollection();
        $this->wishes = new ArrayCollection();
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return User
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set phone
     *
     * @param integer $phone
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return integer 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Add addresses
     *
     * @param \AppBundle\Entity\Address $addresses
     * @return User
     */
    public function addAddress(\AppBundle\Entity\Address $addresses)
    {
        $this->addresses[] = $addresses;

        return $this;
    }

    /**
     * Remove addresses
     *
     * @param \AppBundle\Entity\Address $addresses
     */
    public function removeAddress(\AppBundle\Entity\Address $addresses)
    {
        $this->addresses->removeElement($addresses);
    }

    /**
     * Get addresses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * Add orders
     *
     * @param \AppBundle\Entity\Orders $orders
     * @return User
     */
    public function addOrder(\AppBundle\Entity\Orders $orders)
    {
        $this->orders[] = $orders;

        return $this;
    }

    /**
     * Remove orders
     *
     * @param \AppBundle\Entity\Orders $orders
     */
    public function removeOrder(\AppBundle\Entity\Orders $orders)
    {
        $this->orders->removeElement($orders);
    }

    /**
     * Get orders
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * Add wishes
     *
     * @param \AppBundle\Entity\Wishlist $wishes
     * @return User
     */
    public function addWish(\AppBundle\Entity\Wishlist $wishes)
    {
        $this->wishes[] = $wishes;

        return $this;
    }

    /**
     * Remove wishes
     *
     * @param \AppBundle\Entity\Wishlist $wishes
     */
    public function removeWish(\AppBundle\Entity\Wishlist $wishes)
    {
        $this->wishes->removeElement($wishes);
    }

    /**
     * Get wishes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getWishes()
    {
        return $this->wishes;
    }

    /**
     * Set dateOfBirth
     *
     * @param \DateTime $dateOfBirth
     * @return User
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    /**
     * Get dateOfBirth
     *
     * @return \DateTime 
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * Set gender
     *
     * @param string $gender
     * @return User
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string 
     */
    public function getGender()
    {
        return $this->gender;
    }
}
