<?php

namespace Lthrt\CCSBundle\Form\Combo\ComboTrait;

trait AddCountyTrait
{
    private function addCounty($formOrBuilder)
    {
        $counties = ($this->options['state'] || $this->options['county'])
        ? $this->countyRep->findByCityAndOrState($this->options)
        : $this->countyRep->findNames();
        $counties = $counties->getQuery()->getResult();
        // Doctrine returns an array of array for select
        // so transform to choice list
        $counties = array_flip(array_map(function ($county) {return $county['name'];}, $counties));
        foreach ($counties as $name => $value) {
            $counties[$name] = $name;
        }

        $formOrBuilder->add('county', 'county',
            [
                'data'              => $this->options['county'] ? $this->options['county'] : 0,
                'choices'           => $counties,
                'choices_as_values' => true,
            ]
        );
    }
}
