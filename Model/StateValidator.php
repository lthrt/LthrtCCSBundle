<?php

namespace Lthrt\CCSBundle\Model;

//
// Make sure state is 2 letters and exists or full name exists
//
//

class StateValidator
{
    private $stateRep;

    public function __construct($em)
    {
        $this->stateRep = $em->getRepository('LthrtCCSBundle:State');
    }

    public function validateAbbr($abbr)
    {
        if (!preg_match('/[a-zA-Z]{2}/', $abbr)) {
            return null;
        }
        $state = $this->stateRep->findOneByAbbr($abbr);

        return $state;
    }

    public function validateName($name)
    {
        if (!preg_match('/[a-zA-Z\s]+/', $name)) {
            return null;
        }

        $state = $this->stateRep->findOneByName($name);

        return $state;
    }

    public function validate($state)
    {
        return ($this->validateAbbr($state) || $this->validateName($state));
    }
}
