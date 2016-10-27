<?php

namespace Lthrt\CCSBundle\Repository;

/**
 * CityRepository.
 * All methods return query builders.
 */
class CityRepository extends \Doctrine\ORM\EntityRepository
{
    use \Lthrt\CCSBundle\Repository\Traits\CCSBundleRepositoryTrait;

    const ROOT = 'city';

    public function findByCounty($name)
    {
        return $this->findByCountyStateOrZip(['county' => $name]);
    }

    public function findByCountyStateOrZip($options)
    {
        $options = array_merge(
            [
                'county' => null,
                'state'  => null,
                'zip'    => null,
                'field'  => 'name',
            ],
            $options
        );

        $qb = $this->findItems($options['field']);

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

        if ($options['zip']) {
            $qb->join(self::ROOT . '.zip', ZipRepository::ROOT);
            $qb->andWhere($qb->expr()->eq(ZipRepository::ROOT . '.zip', ':zip'));
            $qb->setParameter('zip', $options['zip']);
        }

        return $qb;
    }

    public function findByState($abbr)
    {
        return $this->findByCountyStateOrZip(['state' => $abbr]);
    }

    public function findByZip($zip)
    {
        return $this->findByCountyStateOrZip(['zip' => $zip]);
    }
}
