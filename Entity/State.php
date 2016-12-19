<?php

namespace Lthrt\CCSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * State.
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Lthrt\CCSBundle\Repository\StateRepository")
 */
class State implements \Lthrt\EntityBundle\Entity\EntityLedger
{
    use \Lthrt\EntityBundle\Entity\AbbrTrait;
    use \Lthrt\EntityBundle\Entity\ActiveTrait;
    use \Lthrt\EntityBundle\Entity\EntityTrait;
    use \Lthrt\EntityBundle\Entity\NameTrait;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="City", mappedBy="state")
     */
    private $city;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="County", mappedBy="state")
     */
    private $county;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Zip", mappedBy="state")
     */
    private $zip;

    public function __construct()
    {
        $this->city   = new \Doctrine\Common\Collections\ArrayCollection();
        $this->county = new \Doctrine\Common\Collections\ArrayCollection();
        $this->zip    = new \Doctrine\Common\Collections\ArrayCollection();
    }
}
