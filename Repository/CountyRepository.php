<?php

namespace Lthrt\CCSBundle\Repository;

/**
 * CountyRepository
 * All methods return query builders.
 */
class CountyRepository extends \Doctrine\ORM\EntityRepository
{
    use \Lthrt\CCSBundle\Repository\Traits\CCSBundleRepositoryTrait;

    const ROOT = 'county';

    public function findByCity($name)
    {
        return $this->findByCityStateOrZip(['city' => $name]);
    }

    public function findByCityStateOrZip($options)
    {
        $options = array_merge(
            [
                'city'  => null,
                'state' => null,
                'zip'   => null,
                'field' => 'name',
            ],
            $options
        );

        $qb = $this->findItems($options['field']);

        if ($options['city']) {
            $qb->join(self::ROOT . '.city', CityRepository::ROOT);
            $qb->andWhere($qb->expr()->eq(CityRepository::ROOT . '.name', ':city'));
            $qb->setParameter('city', ucwords(strtolower($options['city'])));
        }

        if ($options['state']) {
            $qb->join(self::ROOT . '.state', StateRepository::ROOT);
            $qb->andWhere(
                $qb->expr()->orx(
                    $qb->expr()->eq(StateRepository::ROOT . '.abbr', ':stateAbbr'),
                    $qb->expr()->eq(StateRepository::ROOT . '.name', ':state')
                )
            );
            $qb->setParameter('stateAbbr', strtoupper($options['state']));
            $qb->setParameter('state', ucfirst(strtolower($options['state'])));
        }

        if ($options['zip']) {
            $qb->join(self::ROOT . '.zip', ZipRepository::ROOT);
            $qb->andWhere($qb->expr()->eq(ZipRepository::ROOT . '.zip', ':zip'));
            $qb->setParameter('zip', $options['zip']);
        }

        return $qb;
    }

    public function findByState($abbr)
    {
        return $this->findByCityStateOrZip(['state' => $abbr]);
    }

    public function findByZip($zip)
    {
        return $this->findByCityStateOrZip(['zip' => $zip]);
    }
}
