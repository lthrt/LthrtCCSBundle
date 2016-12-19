<?php

namespace Lthrt\CCSBundle\DataFixtures\DataTrait;

//
// Free Trait.
//

trait FreeTrait
{
    private $states;

    public function getStates()
    {
        if (!$this->states) {
            $file                   = __DIR__ . "/../Data/free-zipcode-database.csv";
            $csv                    = fopen($file, 'r');
            $this->states['header'] = array_flip(fgetcsv($csv));
            while ($dataRow = fgetcsv($csv)) {
                var_dump($dateRow);die;
            }
        }

        return $this->states;
    }
}
