<?php

namespace Lthrt\CCSBundle\Controller\Traits;

use Lthrt\CCSBundle\Entity\City;

/**
 * CityNotFoundTrait.
 */
trait CityNotFoundTrait
{
    private function notFound(City $city)
    {
        if (!$city) {
            throw $this->createNotFoundException('Unable to find City entity.');
        }
    }
}
