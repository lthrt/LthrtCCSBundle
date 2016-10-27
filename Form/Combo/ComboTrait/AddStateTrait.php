<?php

namespace Lthrt\CCSBundle\Form\Combo\ComboTrait;

trait AddStateTrait
{
    private function addState($formOrBuilder)
    {
        $formOrBuilder->add('state', 'state',
            [
                'data'          => $this->options['state'],
                'query_builder' => ($this->options['county'] || $this->options['city'])
                ? $this->stateRep->findByCityAndOrCounty($this->options)
                : $this->stateRep->findAll(),
            ]
        );
    }
}
