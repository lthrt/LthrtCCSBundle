<?php

namespace Lthrt\CCSBundle\DataFixtures\DataTrait;

//
// Free Trait.
//

trait CountyTrait
{
    private $rows;

    private $codex = [
        'city'     => 3,
        'county'   => 1,
        'coverage' => 4,
        'state'    => 0,
        'zip'      => 2,
    ];

    private static $countySQL = <<<EOSQL

INSERT INTO county (id, state_id, active, name)
    SELECT
        nextval('city_id_seq'),
        (SELECT id FROM state WHERE name = '<STATE>'),
        true,
        '<COUNTY>'
    WHERE NOT EXISTS (
        SELECT id
        FROM county
        WHERE name = '<COUNTY>'
        AND state_id = (SELECT id FROM state WHERE name = '<STATE>')
        )

;
EOSQL;

    private static $countyCitySQL = <<<EOSQL
INSERT INTO county__city (county_id, city_id)
    SELECT
        (SELECT id FROM county WHERE name = '<COUNTY>' AND state_id = (SELECT id FROM state WHERE name = '<STATE>')),
        (SELECT id FROM city WHERE name ilike '<CITY>' AND state_id = (SELECT id FROM state WHERE name = '<STATE>'))
    WHERE NOT EXISTS (
            SELECT *
            FROM county__city
            WHERE county_id  = (
                            SELECT id
                            FROM county
                            WHERE name = '<COUNTY>'
                            AND state_id = (SELECT id FROM state WHERE name = '<STATE>')
            )
            AND city_id = (
                            SELECT id
                            FROM city
                            WHERE name ilike '<CITY>'
                            AND state_id = (SELECT id FROM state WHERE name = '<STATE>')
                            )
                )
    AND EXISTS (
        SELECT id
            FROM city
            WHERE name ilike '<CITY>'
            AND state_id = (SELECT id FROM state WHERE name = '<STATE>')
        )
;
EOSQL;

    private static $coverageSQL = <<<EOSQL
INSERT INTO coverage (id, county_id, zip_id, coverage)
SELECT
    nextval('coverage_id_seq'),
    (SELECT id FROM county WHERE name = '<COUNTY>' AND state_id = (SELECT id FROM state WHERE name = '<STATE>')),
    (SELECT id FROM zip WHERE zip='<ZIP>'),
    <COVERAGE>
WHERE NOT EXISTS (
                    SELECT *
                    FROM coverage
                    WHERE zip_id  = (SELECT id FROM zip WHERE zip = '<ZIP>')
                    AND county_id = (
                                    SELECT id
                                    FROM county
                                    WHERE name = '<COUNTY>'
                                    AND state_id = (SELECT id FROM state WHERE name = '<STATE>')
                                    )
                )
;

EOSQL;

    public function getRows()
    {
        if (!$this->rows) {
            $file = __DIR__ . "/../Data/CountyCoverage.csv";
            $csv  = fopen($file, 'r');

            // Dump Header
            fgetcsv($csv);

            while ($dataRow = fgetcsv($csv)) {
                $this->rows[] = $dataRow;
            }
        }

        return $this->rows;
    }

    public function getCity($dataRow)
    {
        return $dataRow[$this->codex['city']];
    }

    public function getCounty($dataRow)
    {
        return $dataRow[$this->codex['county']];
    }

    public function getCoverage($dataRow)
    {
        return $dataRow[$this->codex['coverage']] / 100;
    }

    public function getState($dataRow)
    {
        return $dataRow[$this->codex['state']];
    }

    public function getZip($dataRow)
    {
        return $dataRow[$this->codex['zip']];
    }
}
