<?php

namespace Lthrt\CCSBundle\Controller\Traits;

use Lthrt\CCSBundle\Form\Combo\CityCountyStateCombo;

/**
 * CountyFormController Trait.
 */
trait CityCountyStateFormControllerTrait
{
    private function createCityCountyStateForm($options = [])
    {
        $options = array_merge(
            [
                'action' => null,
                'city'   => null,
                'county' => null,
                'state'  => null,
            ],
            $options
        );

        return $this->createFinalForm($options);
    }

    private function createCityCountyForm($options = [])
    {
        $options = array_merge(
            [
                'action' => null,
                'city'   => null,
                'county' => null,
                'state'  => false,
            ],
            $options
        );

        return $this->createFinalForm($options);
    }

    private function createCityStateForm($options = [])
    {
        $options = array_merge(
            [
                'action' => null,
                'city'   => null,
                'county' => false,
                'state'  => null,
            ],
            $options
        );

        return $this->createFinalForm($options);
    }

    private function createCountyStateForm($options = [])
    {
        $options = array_merge(
            [
                'action' => null,
                'city'   => false,
                'county' => null,
                'state'  => null,
            ],
            $options
        );

        return $this->createFinalForm($options);
    }

    public function createFinalForm($options)
    {
        $form = $this->createForm(
            new CityCountyStateCombo($this->getDoctrine()->getManager(), $options),
            null,
            [
                'method' => 'POST',
                'action' => $options['action'],
            ]
        );

        return $form;
    }
}
