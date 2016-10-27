<?php

namespace Lthrt\CCSBundle\Controller\Traits;

use Symfony\Component\HttpFoundation\Request;

/**
 * API Validator Trait.
 */
trait ApiValidatorTrait
{
    // Not sure if these will be used
    // Doctrine SQL projections just give null results back
    // So this protection may not be necessary

    private function validateCounty($county)
    {
        if (!$this->get('county.validator')->validate($county)) {
            // throw new \Exception('Bad County: ' . $county);
        }
    }

    private function validateCity($city)
    {
        if (!$this->get('city.validator')->validate($city)) {
            // throw new \Exception('Bad City: ' . $city);
        }
    }

    public function validateState($state)
    {
        if (!$this->get('state.validator')->validate($state)) {
            // throw new \Exception('Bad State: ' . $state);
        }
    }

    public function validateZip($zip)
    {
        if (!$this->get('zip.validator')->validate($zip)) {
            // throw new \Exception('Bad Zip Code: ' . $zip);
        }
    }

    public function validateRequest(Request $request)
    {
        if ($request->get('city')) {
            $this->validateCity($request->get('city'));
        }
        if ($request->get('county')) {
            $this->validateCounty($request->get('county'));
        }
        if ($request->get('state')) {
            $this->validateState($request->get('state'));
        }
        if ($request->get('zip')) {
            $this->validateZip($request->get('zip'));
        }
    }
}
