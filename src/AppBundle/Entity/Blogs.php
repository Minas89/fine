<?php
/**
 * Created by PhpStorm.
 * User: Minas
 * Date: 12/28/2017
 * Time: 12:55 AM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Blogs
 * @package AppBundle\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\BlogsRepository")
 * @ORM\Table(name="blogs")
 */
class Blogs extends AbstractEntity
{


    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Blogs
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
