<?php

namespace Lthrt\CCSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Coverage
 * Many To Many Join table with attribute of percent of zip code in county
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Lthrt\CCSBundle\Repository\CountyRepository")
 */
class Coverage implements \Lthrt\EntityBundle\Entity\EntityLedger
{
    use \Lthrt\EntityBundle\Entity\EntityTrait;

    /**
     * @var \Lthrt\CCSBundle\Entity\County
     *
     * @ORM\ManyToOne(targetEntity="County", inversedBy="zip")
     */
    private $county;

    /**
     * @var float
     *
     * @ORM\Column(name="coverage", type="float")
     */
    private $coverage;

    /**
     * @var \Lthrt\CCSBundle\Entity\Zip
     *
     * @ORM\ManyToOne(targetEntity="Zip", inversedBy="county")
     */
    private $zip;

    public function __construct() {}
}