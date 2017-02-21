<?php

namespace Lthrt\CCSBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * County API controller.
 *
 * @Route("/")
 */
class ApiController extends Controller
{
    use \Lthrt\CCSBundle\Controller\Traits\ApiValidatorTrait;

    /**
     * Returns JSON list of zips by county
     *
     * @Route("/city/county/{county}/", name="city_county_json")
     * @Route("/city/county/{county}/state/{state}/", name="city_county_state_json")
     * @Route("/city/county/{county}/state/{state}/zip/{zip}/", name="city_county_state_zip_json")
     * @Route("/city/county/{county}/zip/{zip}/", name="city_county_zip_json")
     * @Route("/city/county/{county}/zip/{zip}/state/{state}/", name="city_county_zip_state_json")
     * @Route("/city/state/{state}/", name="city_state_json")
     * @Route("/city/state/{state}/county/{county}/", name="city_state_county_json")
     * @Route("/city/state/{state}/county/{county}/zip/{zip}/", name="city_state_county_zip_json")
     * @Route("/city/state/{state}/zip/{zip}/", name="city_state_zip_json")
     * @Route("/city/state/{state}/zip/{zip}/county/{county}/", name="city_state_zip_county_json")
     * @Route("/city/zip/{zip}/", name="city_zip_json")
     * @Route("/city/zip/{zip}/county/{county}/", name="city_zip_county_json")
     * @Route("/city/zip/{zip}/county/{county}/state/{state}/", name="city_zip_county_state_json")
     * @Route("/city/zip/{zip}/state/{state}/", name="city_zip_state_json")
     * @Route("/city/zip/{zip}/state/{state}/county/{county}/", name="city_zip_state_county_json")
     *
     * @Method("GET")
     */

    public function cityAction(
        Request $request,
                $county = null,
                $state = null,
                $zip = null
    ) {
        $this->validateRequest($request);
        $cityCollection = $this->getDoctrine()
            ->getManager('ccs')
            ->getRepository('LthrtCCSBundle:City')
            ->findByCountyStateOrZip(
                [
                    'county' => $county,
                    'state'  => $state,
                    'zip'    => $zip,
                ]
            )
            ->getQuery()
            ->getResult();

        $response = new JsonResponse($cityCollection);
        return $response;
    }

    /**
     * Returns JSON list of zips by county
     *
     * @Route("/county/city/{city}/", name="county_city_json")
     * @Route("/county/city/{city}/state/{state}/", name="county_city_state_json")
     * @Route("/county/city/{city}/state/{state}/zip/{zip}/", name="county_city_state_zip_json")
     * @Route("/county/city/{city}/zip/{zip}/", name="county_city_zip_json")
     * @Route("/county/city/{city}/zip/{zip}/state/{state}/", name="county_city_zip_state_json")
     * @Route("/county/state/{state}/", name="county_state_json")
     * @Route("/county/state/{state}/city/{city}/", name="county_state_city_json")
     * @Route("/county/state/{state}/city/{city}/zip/{zip}/", name="county_state_city_zip_json")
     * @Route("/county/state/{state}/zip/{zip}/", name="county_state_zip_json")
     * @Route("/county/state/{state}/zip/{zip}/city/{city}/", name="county_state_zip_city_json")
     * @Route("/county/zip/{zip}/", name="county_zip_json")
     * @Route("/county/zip/{zip}/city/{city}/", name="county_zip_city_json")
     * @Route("/county/zip/{zip}/city/{city}/state/{state}/", name="county_zip_city_state_json")
     * @Route("/county/zip/{zip}/state/{state}/", name="county_zip_state_json")
     * @Route("/county/zip/{zip}/state/{state}/city/{city}/", name="county_zip_state_city_json")
     *
     * @Method("GET")
     */

    public function countyAction(
        Request $request,
                $city = null,
                $state = null,
                $zip = null
    ) {
        $this->validateRequest($request);
        $countyCollection = $this->getDoctrine()
            ->getManager('ccs')
            ->getRepository('LthrtCCSBundle:County')
            ->findByCityStateOrZip(
                [
                    'city'  => $city,
                    'state' => $state,
                    'zip'   => $zip,
                ]
            )
            ->getQuery()
            ->getResult();

        $response = new JsonResponse($countyCollection);

        return $response;
    }

    /**
     * Returns JSON list of state by county
     *
     * @Route("/state/city/{city}/", name="state_city_json")
     * @Route("/state/city/{city}/county/{county}/", name="state_city_county_json")
     * @Route("/state/city/{city}/county/{county}/zip/{zip}/", name="state_city_county_zip_json")
     * @Route("/state/city/{city}/zip/{zip}/", name="state_city_zip_json")
     * @Route("/state/city/{city}/zip/{zip}/county/{county}/", name="state_city_zip_county_json")
     * @Route("/state/county/{county}/", name="state_county_json")
     * @Route("/state/county/{county}/city/{city}/", name="state_county_city_json")
     * @Route("/state/county/{county}/city/{city}/zip/{zip}/", name="state_county_city_zip_json")
     * @Route("/state/county/{county}/zip/{zip}/", name="state_county_zip_json")
     * @Route("/state/county/{county}/zip/{zip}/city/{city}/", name="state_county_zip_city_json")
     * @Route("/state/zip/{zip}/", name="state_zip_json")
     * @Route("/state/zip/{zip}/city/{city}/", name="state_zip_city_json")
     * @Route("/state/zip/{zip}/city/{city}/county/{county}/", name="state_zip_city_county_json")
     * @Route("/state/zip/{zip}/county/{county}/", name="state_zip_county_json")
     * @Route("/state/zip/{zip}/county/{county}/city/{city}/", name="state_zip_county_city_json")
     *
     * @Method("GET")
     */

    public function stateAction(
        Request $request,
                $city = null,
                $county = null,
                $zip = null
    ) {
        $this->validateRequest($request);
        $stateCollection = $this->getDoctrine()
            ->getManager('ccs')
            ->getRepository('LthrtCCSBundle:State')
            ->findByCityCountyOrZip(
                [
                    'city'   => $city,
                    'county' => $county,
                    'zip'    => $zip,
                ]
            )
            ->getQuery();

        $stateCollection = $stateCollection
            ->getResult();

        $response = new JsonResponse($stateCollection);

        return $response;
    }

    /**
     * Returns JSON list of zips by county
     *
     * @Route("/zip/city/{city}/", name="zip_city_json")
     * @Route("/zip/city/{city}/county/{county}/", name="zip_city_county_json")
     * @Route("/zip/city/{city}/county/{county}/state/{state}/", name="zip_city_county_state_json")
     * @Route("/zip/city/{city}/state/{state}/", name="zip_city_state_json")
     * @Route("/zip/city/{city}/state/{state}/county/{county}/", name="zip_city_state_county_json")
     * @Route("/zip/county/{county}/", name="zip_county_json")
     * @Route("/zip/county/{county}/city/{city}/", name="zip_county_city_json")
     * @Route("/zip/county/{county}/city/{city}/state/{state}/", name="zip_county_city_state_json")
     * @Route("/zip/county/{county}/state/{state}/", name="zip_county_state_json")
     * @Route("/zip/county/{county}/state/{state}/city/{city}/", name="zip_county_state_city_json")
     * @Route("/zip/state/{state}/", name="zip_state_json")
     * @Route("/zip/state/{state}/city/{city}/", name="zip_state_city_json")
     * @Route("/zip/state/{state}/city/{city}/county/{county}/", name="zip_state_city_county_json")
     * @Route("/zip/state/{state}/county/{county}/", name="zip_state_county_json")
     * @Route("/zip/state/{state}/county/{county}/city/{city}/", name="zip_state_county_city_json")
     *
     * @Method("GET")
     */

    public function zipAction(
        Request $request,
                $city = null,
                $county = null,
                $state = null
    ) {
        $this->validateRequest($request);
        $zipCollection = $this->getDoctrine()
            ->getManager('ccs')
            ->getRepository('LthrtCCSBundle:Zip')
            ->findByCityCountyOrState(
                [
                    'city'   => $city,
                    'county' => $county,
                    'state'  => $state,
                ]
            )
            ->getQuery()
            ->getResult();

        $response = new JsonResponse($zipCollection);

        return $response;
    }
}
