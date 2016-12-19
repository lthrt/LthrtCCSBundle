<?php
namespace Lthrt\CCSBundle\DataFixtures;

use Lthrt\CCSBundle\DataFixtures\DataTrait\FreeTrait;

class FreeLoader
{
    use FreeTrait;

    // because of length, source array at end of class

    private $em;

    public function __construct($em)
    {
        $this->em   = $em;
        $this->rows = $this->getRows();
    }

    public function loadZips($overwrite = false)
    {
        $dbStates = $this->em->getRepository('LthrtCCSBundle:State')
            ->createQueryBuilder('state', 'state.abbr')->getQuery()->getResult();

        $insertedCities = [];
        $insertZips     = [];

        foreach ($this->rows as $row) {
            $city       = str_replace('\'', '\'\'', $this->getCity($row));
            $state      = $this->getState($row);
            $zip        = $this->getZip($row);
            $citySQL    = str_replace(['<CITY>', '<STATE>', '<ZIP>'], [$city, $state, $zip], $this::$citySQL);
            $zipSQL     = str_replace(['<CITY>', '<STATE>', '<ZIP>'], [$city, $state, $zip], $this::$zipSQL);
            $zipCitySQL = str_replace(['<CITY>', '<STATE>', '<ZIP>'], [$city, $state, $zip], $this::$zipCitySQL);

            $conn = $this->em->getConnection();

            if ($conn->executeUpdate($citySQL)) {
                $insertedCities[] = $city;
            } else {
                $ignoredCities[] = $city;
            }

            if ($conn->executeUpdate($zipSQL)) {
                $insertedZips[] = $zip;
            } else {
                $ignoredZips[] = $zip;
            }

            $conn->executeUpdate($zipCitySQL);
        }

        return [
            'insertedCities' => $insertedCities,
            'ignoredCities'  => $ignoredCities,
            'insertedZips'   => $insertedZips,
            'ignoredZips'    => $ignoredZips,
        ];
    }
}
