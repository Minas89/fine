<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\AbstractEntity;

/**
 * Class Texts
 * @package AppBundle\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\TextsRepository")
 * @ORM\Table(name="texts")
 */
class Texts extends AbstractEntity
{


    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Texts
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
