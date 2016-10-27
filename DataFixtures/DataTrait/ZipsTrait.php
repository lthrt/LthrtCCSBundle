<?php

namespace Lthrt\CCSBundle\DataFixtures\DataTrait;

//
// Zips Trait.
//

trait ZipsTrait
{
    private $zips;

    public function getZips()
    {
        if (!$this->zips) {
            $file                 = __DIR__ . "/../Data/zips.csv";
            $csv                  = fopen($file, 'r');
            $this->zips['header'] = array_flip(fgetcsv($csv));
            while (($dataRow = fgetcsv($csv)) !== false) {
                $this->zips[str_pad($dataRow[$this->zips['header']['zip']], 5, '0', STR_PAD_LEFT)] = [
                    'city'   => str_replace('St.', 'Saint', $dataRow[$this->zips['header']['city']]),
                    'state'  => $dataRow[$this->zips['header']['state']],
                    'county' => $dataRow[$this->zips['header']['county']],
                ];
            }
        }

        return $this->zips;
    }
}
