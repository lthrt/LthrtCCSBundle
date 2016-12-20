<?php

namespace Lthrt\CCSBundle\DataFixtures\DataTrait;

//
// Free Trait.
//

trait FreeTrait
{
    private $rows;

    private $codex = [
        'country'  => 12,
        'location' => 13,
        'state'    => 4,
        'type'     => 2,
        'valid'    => 5,
        'zip'      => 1,
    ];

    private static $citySQL = <<<EOSQL

INSERT INTO city (id, state_id, active, name)
    SELECT
        nextval('city_id_seq'),
        (SELECT id FROM state WHERE abbr = '<STATE>'),
        true,
        '<CITY>'
    WHERE NOT EXISTS
        (
        SELECT id
        FROM city
        WHERE name = '<CITY>'
        AND state_id = (SELECT id FROM state WHERE abbr = '<STATE>')
        )
;
EOSQL;

    private static $zipSQL = <<<EOSQL

INSERT INTO zip (id, active, zip)
    SELECT
        nextval('zip_id_seq'),
        true,
        '<ZIP>'
    WHERE NOT EXISTS
        ( SELECT id FROM zip WHERE zip = '<ZIP>' )
;
EOSQL;

    private static $zipCitySQL = <<<EOSQL
INSERT INTO zip__city (zip_id, city_id)
SELECT
    (SELECT id FROM zip WHERE zip='<ZIP>'),
    (SELECT id FROM city WHERE name = '<CITY>' AND state_id = (SELECT id FROM state WHERE abbr = '<STATE>'))
WHERE NOT EXISTS (
                    SELECT *
                    FROM zip__city
                    WHERE zip_id  = (SELECT id FROM zip WHERE zip = '<ZIP>')
                    AND city_id = (
                                    SELECT id
                                    FROM city
                                    WHERE name = '<CITY>'
                                    AND state_id = (SELECT id FROM state WHERE abbr = '<STATE>')
                                    )
                )
;
EOSQL;

    private static $zipStateSQL = <<<EOSQL
INSERT INTO zip__state (zip_id, state_id)
SELECT
    (SELECT id FROM zip WHERE zip='<ZIP>'),
    (SELECT id FROM state WHERE abbr = '<STATE>')
WHERE NOT EXISTS (
                    SELECT *
                    FROM zip__state
                    WHERE zip_id  = (SELECT id FROM zip WHERE zip = '<ZIP>')
                    AND state_id = (SELECT id FROM state WHERE abbr = '<STATE>')
                )
;
EOSQL;

    public function getRows()
    {
        if (!$this->rows) {
            $file = __DIR__ . "/../Data/free-zipcode-database.csv";
            $csv  = fopen($file, 'r');

            // Dump Header
            fgetcsv($csv);

            while ($dataRow = fgetcsv($csv)) {
                if ($this->getValid($dataRow) && $this->getCity($dataRow)) {
                    $this->rows[] = $dataRow;
                }
            }
        }

        return $this->rows;
    }

    public function getCity($dataRow)
    {
        return strstr($dataRow[$this->codex['location']], ',', true);
    }

    public function getCountry($dataRow)
    {
        return $dataRow[$this->codex['country']];
    }

    public function getState($dataRow)
    {
        return $dataRow[$this->codex['state']];
    }

    public function getType($dataRow)
    {
        return $dataRow[$this->codex['type']];
    }

    public function getValid($dataRow)
    {
        return 'PRIMARY' == $dataRow[$this->codex['valid']]
            ||
            'ACCEPTABLE' == $dataRow[$this->codex['valid']]
        ;
    }

    public function getZip($dataRow)
    {
        return $dataRow[$this->codex['zip']];
    }
}
