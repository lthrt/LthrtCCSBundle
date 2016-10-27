<?php

namespace Lthrt\CCSBundle\Repository\Traits;

//
// AddressFormRepository Trait.
//

trait CCSBundleRepositoryTrait
{
    private function qb($index = null)
    {
        if ($index) {
            $qb = $this->createQueryBuilder(self::ROOT, self::ROOT . '.' . $index);
        } else {
            $qb = $this->createQueryBuilder(self::ROOT);
        }

        return $qb;
    }

    public function findItems($field)
    {
        $qb = $this->qb();
        $qb->orderBy(self::ROOT . '.' . $field);
        $qb->select(self::ROOT . '.' . $field);
        $qb->distinct();

        return $qb;
    }
}
