<?php

namespace Lthrt\CCSBundle\Repository;

/**
 * ZipRepository.
 */
class ZipRepository extends \Doctrine\ORM\EntityRepository
{
    use \Lthrt\CCSBundle\Repository\Traits\CCSBundleRepositoryTrait;

    const ROOT = 'zip';

    public function findByCity($name)
    {
        return $this->findByCityCountyOrState(['city' => $name]);
    }

    public function findByCityCountyOrState($options)
    {
        $options = array_merge(
            [
                'city'   => null,
                'county' => null,
                'state'  => null,
                'field'  => ['zip'],
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

        return $qb;
    }

    public function findByCounty($name)
    {
        return $this->findByCityCountyOrState(['county' => $name]);
    }

    public function findByState($abbr)
    {
        return $this->findByCityCountyOrState(['state' => $abbr]);
    }
}
