<?php

namespace Lthrt\CCSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * County.
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Lthrt\CCSBundle\Repository\CountyRepository")
 */
class County implements \Lthrt\EntityBundle\Entity\EntityLedger
{
    use \Lthrt\EntityBundle\Entity\ActiveTrait;
    use \Lthrt\EntityBundle\Entity\EntityTrait;
    use \Lthrt\EntityBundle\Entity\NameTrait;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="City", inversedBy="county")
     * @ORM\JoinTable(name="county__city"))
     */
    private $city;

    /**
     * @var \Lthrt\CCSBundle\Entity\State
     *
     * @ORM\ManyToOne(targetEntity="State", inversedBy="county")
     * @ORM\JoinTable(name="city__state")
     */
    private $state;
    /**
     * @var \Lthrt\CCSBundle\Entity\Coverage
     *
     * @ORM\OneToMany(targetEntity="Coverage", mappedBy="county")
     */
    private $zip;

    public function __construct()
    {
        $this->city = new \Doctrine\Common\Collections\ArrayCollection();
        $this->zip  = new \Doctrine\Common\Collections\ArrayCollection();
    }
}
