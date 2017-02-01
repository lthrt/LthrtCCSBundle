<?php

namespace Lthrt\CCSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * City.
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Lthrt\CCSBundle\Repository\CityRepository")
 */
class City implements \Lthrt\EntityBundle\Entity\EntityLedger
{
    use \Lthrt\EntityBundle\Entity\ActiveTrait;
    use \Lthrt\EntityBundle\Entity\DoctrineEntityTrait;
    use \Lthrt\EntityBundle\Entity\NameTrait;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="County", mappedBy="city")
     */
    private $county;

    /**
     * @var \Lthrt\CCSBundle\Entity\State
     *
     * @ORM\ManyToOne(targetEntity="State", inversedBy="city")
     * @ORM\JoinTable(name="city__state")
     */
    private $state;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Zip", mappedBy="city")
     */
    private $zip;

    public function __construct()
    {
        $this->county = new \Doctrine\Common\Collections\ArrayCollection();
        $this->zip    = new \Doctrine\Common\Collections\ArrayCollection();
    }
}
