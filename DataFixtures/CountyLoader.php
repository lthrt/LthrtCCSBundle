<?php
namespace Lthrt\CCSBundle\DataFixtures;

use Lthrt\CCSBundle\DataFixtures\CountyTrait;

class CountyLoader
{
    use CountyTrait;

    private $em;

    public function __construct($em)
    {
        $this->em   = $em;
        $this->rows = $this->getRows();
    }

    public function loadCounties($overwrite = false)
    {
        $dbStates = $this->em->getRepository('LthrtCCSBundle:State')
            ->createQueryBuilder('state', 'state.abbr')->getQuery()->getResult();

        $insertedCities    = [];
        $insertZips        = [];
        $ignoredCoverages  = [];
        $insertedCoverages = [];

        foreach ($this->rows as $row) {
            $city     = $this->getCity($row);
            $county   = $this->getCounty($row);
            $coverage = $this->getCoverage($row);
            $state    = $this->getState($row);
            $zip      = $this->getZip($row);

            $countySQL     = str_replace(['<CITY>', '<STATE>', '<ZIP>', '<COVERAGE>', '<COUNTY>'], [$city, $state, $zip, $coverage, $county], $this::$countySQL);
            $coverageSQL   = str_replace(['<CITY>', '<STATE>', '<ZIP>', '<COVERAGE>', '<COUNTY>'], [$city, $state, $zip, $coverage, $county], $this::$coverageSQL);
            $countyCitySQL = str_replace(['<CITY>', '<STATE>', '<ZIP>', '<COVERAGE>', '<COUNTY>'], [$city, $state, $zip, $coverage, $county], $this::$countyCitySQL);
            $zipStateSQL   = str_replace(['<CITY>', '<STATE>', '<ZIP>', '<COVERAGE>', '<COUNTY>'], [$city, $state, $zip, $coverage, $county], $this::$countyCitySQL);

            $conn = $this->em->getConnection();

            if ($conn->executeUpdate($countySQL)) {
                $insertedCounties[] = $county;
            } else {
                $ignoredCounties[] = $county;
            }

            if ($conn->executeUpdate($coverageSQL)) {
                $insertedCoverages[] = $zip;
            } else {
                $ignoredCoverages[] = $zip;
            }

            $conn->executeUpdate($countyCitySQL);

            // catches any missed by FreeLoader
            $conn->executeUpdate($zipStateSQL);
        }

        return [
            'insertedCounties'  => $insertedCounties,
            'ignoredCounties'   => $ignoredCounties,
            'insertedCoverages' => $insertedCoverages,
            'ignoredCoverages'  => $ignoredCoverages,
        ];
    }
}
