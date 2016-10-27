<?php

namespace Lthrt\CCSBundle\Model;

//
// Make sure county exists
//
//

class CountyValidator
{
    private $countyRep;

    public function __construct($em)
    {
        $this->countyRep = $em->getRepository('LthrtCCSBundle:County');
    }

    public function validate($name)
    {
        if (!preg_match('/[a-zA-Z\s]+/', $name)) {
            return null;
        }

        $county = $this->countyRep->findOneByName($name);

        return $county;
    }
}
