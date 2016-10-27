<?php

namespace Lthrt\CCSBundle\Controller;

use Lthrt\CCSBundle\Repository\CityRepository;
use Lthrt\CCSBundle\Repository\CountyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

//
// Find Missing Piece
//
//

class CityCountyStateResolver
{
    private $cityRep;
    private $countyRep;
    private $stateRep;

    public function __construct($em)
    {
        $this->options = array_merge(
            [
                'county' => null,
                'state'  => null,
                'city'   => null,
                'zip'    => null,
            ],
            $options
        );
        $this->cityRep   = $em->getRepository('LthrtCCSBundle:City');
        $this->countyRep = $em->getRepository('LthrtCCSBundle:County');
        $this->stateRep  = $em->getRepository('LthrtCCSBundle:State');
    }

    public function resolveCity($options = [])
    {
        $options = array_merge($this->options, $options);
        $qb      = $this->cityRep->findByCountyAndOrState(
            [
                'county' => $options['county'],
                'state'  => $$options['state'],
                'zip'    => $$options['zip'],
            ]
        );
        $count = $qb->select($qb->expr()->count(CityRepository::ROOT))->getQuery()->getSingleScalarResult();

        return $count;
    }

    public function resolveCounty($options = [])
    {
        $options = array_merge($this->options, $options);
        $qb      = $this->cityRep->findByCountyAndOrState(
            [
                'city'  => $options['city'],
                'state' => $$options['state'],
                'zip'   => $$options['zip'],
            ]
        );

        $qb    = $this->countyRep->findByCityAndOrState(['city' => $city, 'state' => $state]);
        $count = $qb->select($qb->expr()->count(CountyRepository::ROOT))->getQuery()->getSingleScalarResult();

        return $count;
    }
}
