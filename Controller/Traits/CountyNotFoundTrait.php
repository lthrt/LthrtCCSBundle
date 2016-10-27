<?php

namespace Lthrt\CCSBundle\Controller\Traits;

use Lthrt\CCSBundle\Entity\County;

/**
 * CountyNotFoundTrait.
 */
trait CountyNotFoundTrait
{
    private function notFound(County $county)
    {
        if (!$county) {
            throw $this->createNotFoundException('Unable to find County entity.');
        }
    }
}
