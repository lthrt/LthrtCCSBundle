<?php

namespace Lthrt\CCSBundle\DataFixtures;

//
// States Trait.
//

trait StatesTrait
{
    private $states;

    public function getStates()
    {
        if (!$this->states) {
            $file                   = __DIR__ . "/Data/states.csv";
            $csv                    = fopen($file, 'r');
            $this->states['header'] = array_flip(fgetcsv($csv));
            while ($dataRow = fgetcsv($csv)) {
                $this->states[$dataRow[$this->states['header']['abbr']]] = $dataRow[$this->states['header']['name']];
            }
        }

        return $this->states;
    }
}
