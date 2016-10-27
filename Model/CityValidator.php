<?php

namespace Lthrt\CCSBundle\Model;

//
// Make sure city exists
//
//

class CityValidator
{
    private $cityRep;

    public function __construct($em)
    {
        $this->cityRep = $em->getRepository('LthrtCCSBundle:City');
    }

    public function validate($name)
    {
        if (!preg_match('/[a-zA-Z\s]+/', $name)) {
            return null;
        }

        $city = $this->cityRep->findOneByName($name);

        return $city;
    }
}
