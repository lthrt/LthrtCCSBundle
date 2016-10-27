<?php

namespace Lthrt\CCSBundle\Model;

//
// Make sure Zip Code is 5 digits and exists
//
//

class ZipValidator
{
    private $zipRep;

    public function __construct($em)
    {
        $this->zipRep = $em->getRepository('LthrtCCSBundle:Zip');
    }

    public function validate($zip)
    {
        if (!preg_match('/\d{5}/', $zip)) {
            return null;
        }

        $zip = $this->zipRep->findOneByZip($zip);

        return $zip;
    }
}
