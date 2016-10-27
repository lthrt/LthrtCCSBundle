<?php

namespace Lthrt\CCSBundle\Controller\Traits;

use Lthrt\CCSBundle\Entity\State;

/**
 * StateNotFoundTrait.
 */
trait StateNotFoundTrait
{
    private function notFound(State $state)
    {
        if (!$state) {
            throw $this->createNotFoundException('Unable to find State entity.');
        }
    }
}
