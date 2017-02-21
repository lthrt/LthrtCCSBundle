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

    public function findItems($fields)
    {
        if (is_array($fields)) {
        } else {
            $fields = [$fields];
        }

        $qb = $this->qb();
        $qb->resetDqlPart('select');

        foreach ($fields as $field) {
            $qb->orderBy(self::ROOT . '.' . $field);
            $qb->addSelect(self::ROOT . '.' . $field);
        }

        $qb->distinct();

        return $qb;
    }
}
