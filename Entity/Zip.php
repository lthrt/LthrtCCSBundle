<?php

namespace Lthrt\CCSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Zip.
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Lthrt\CCSBundle\Repository\ZipRepository")
 */
class Zip implements \Lthrt\EntityBundle\Entity\EntityLedger
{
    use \Lthrt\EntityBundle\Entity\ActiveTrait;
    use \Lthrt\EntityBundle\Entity\EntityTrait;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="City", inversedBy="zip")
     * @ORM\JoinTable(name="zip__city")
     */
    private $city;

    /**
     * @var \Lthrt\CCSBundle\Entity\Coverage
     *
     * @ORM\OneToMany(targetEntity="Coverage", mappedBy="zip")
     */
    private $county;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="State", inversedBy="zip")
     * @ORM\JoinTable(name="zip__state")
     */
    private $state;

    /**
     * @var string
     *
     * @ORM\Column(name="zip", type="string", length=5)
     */
    private $zip;

    public function __construct()
    {
        $this->city   = new \Doctrine\Common\Collections\ArrayCollection();
        $this->county = new \Doctrine\Common\Collections\ArrayCollection();
        $this->state  = new \Doctrine\Common\Collections\ArrayCollection();
    }
}
