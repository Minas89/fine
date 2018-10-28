<?php
/**
 * Created by PhpStorm.
 * User: minastonakanyan
 * Date: 8/19/18
 * Time: 1:05 AM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Titles
 * @package AppBundle\Entity
 * @ORM\Entity()
 * @ORM\Table(name="titles")
 */
class Titles
{
    const TOP = 'top';
    const BIG_BANNER = 'big_banner';
    const NEW_ARRIVALS = 'new_arrivals';
    const SH_B_CAT = 'shop_by_category';

    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", name="title_arm", nullable=true)
     */
    protected $titleArm;

    /**
     * @ORM\Column(type="string", name="title_rus", nullable=true)
     */
    protected $titleRus;

    /**
     * @ORM\Column(type="string", name="title_eng")
     */
    protected $titleEng;

    /**
     * @ORM\Column(type="string", name="link")
     */
    protected $link;

    /**
     * Set titleArm
     *
     * @param string $titleArm
     * @return Titles
     */
    public function setTitleArm($titleArm)
    {
        $this->titleArm = $titleArm;

        return $this;
    }

    /**
     * Get titleArm
     *
     * @return string 
     */
    public function getTitleArm()
    {
        return $this->titleArm;
    }

    /**
     * Set titleRus
     *
     * @param string $titleRus
     * @return Titles
     */
    public function setTitleRus($titleRus)
    {
        $this->titleRus = $titleRus;

        return $this;
    }

    /**
     * Get titleRus
     *
     * @return string 
     */
    public function getTitleRus()
    {
        return $this->titleRus;
    }

    /**
     * Set titleEng
     *
     * @param string $titleEng
     * @return Titles
     */
    public function setTitleEng($titleEng)
    {
        $this->titleEng = $titleEng;

        return $this;
    }

    /**
     * Get titleEng
     *
     * @return string 
     */
    public function getTitleEng()
    {
        return $this->titleEng;
    }

    /**
     * Set link
     *
     * @param string $link
     * @return Titles
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string 
     */
    public function getLink()
    {
        return $this->link;
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
}
