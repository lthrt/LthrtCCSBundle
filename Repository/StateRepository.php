<?php

namespace Lthrt\CCSBundle\Repository;

/**
 * StateRepository.
 * All methods return query builders.
 */
class StateRepository extends \Doctrine\ORM\EntityRepository
{
    use \Lthrt\CCSBundle\Repository\Traits\CCSBundleRepositoryTrait;

    const ROOT = 'state';

    public function findByCity($name)
    {
        return $this->findByCityCountyOrZip(['city' => $name]);
    }

    public function findByCityCountyOrZip($options)
    {
        $options = array_merge(
            [
                'city'   => null,
                'county' => null,
                'zip'    => null,
                'field'  => 'abbr',
            ],
            $options
        );

        $qb = $this->findItems($options['field']);

        if ($options['city']) {
            $qb->join(self::ROOT . '.city', CityRepository::ROOT);
            $qb->andWhere($qb->expr()->eq(CityRepository::ROOT . '.name', ':city'));
            $qb->setParameter('city', ucwords(strtolower($options['city'])));
        }

        if ($options['county']) {
            $qb->join(self::ROOT . '.county', CountyRepository::ROOT);
            $qb->andWhere($qb->expr()->eq(CountyRepository::ROOT . '.name', ':county'));
            $qb->setParameter('county', ucwords(strtolower($options['county'])));
        }

        if ($options['zip']) {
            $qb->join(self::ROOT . '.zip', ZipRepository::ROOT);
            $qb->andWhere($qb->expr()->eq(ZipRepository::ROOT . '.zip', ':zip'));
            $qb->setParameter('zip', $options['zip']);
        }

        return $qb;
    }

    public function findByCounty($name)
    {
        return $this->findByCityCountyOrZip(['county' => $name]);
    }

    public function findByZip($zip)
    {
        return $this->findByCityCountyOrZip(['zip' => $zip]);
    }
}
