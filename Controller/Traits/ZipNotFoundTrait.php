<?php

namespace Lthrt\CCSBundle\Controller\Traits;

use Lthrt\CCSBundle\Entity\Zip;

/**
 * ZipNotFoundTrait.
 */
trait ZipNotFoundTrait
{
    private function notFound(Zip $zip)
    {
        if (!$zip) {
            throw $this->createNotFoundException('Unable to find Zip entity.');
        }
    }
}
