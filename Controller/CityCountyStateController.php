<?php

namespace Lthrt\CCSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

//
// Combo Controller
//
//

class CityCountyStateController extends Controller
{
    use \Lthrt\CCSBundle\Controller\Traits\CityCountyStateFormControllerTrait;

    public function formAction(
        Request $request,
        County  $county = null,
        State   $state = null,
        City    $city = null
    ) {
        $options = [];

        if ($request->request->get('state')) {
            $state = $this->getDoctrine()->getManager()
                ->getRepository('LthrtCCSBundle:State')
                ->findOneById(intval($request->request->get('state')));
        }

        if ($request->request->get('county')) {
            $county = $request->request->get('county');
        }

        if ($request->request->get('city')) {
            $city = $request->request->get('city');
        }

        if ($city) {
            $options['city'] = $city;
        }
        if ($county) {
            $options['county'] = $county;
        }
        if ($state) {
            $options['state'] = $state->getAbbr();
        }

        $options['action'] = $this->generateUrl('city_county_state_form');

        $form = $this->createCityCountyStateForm($options);

        $form->handleRequest($request);

        return $this->render('LthrtCCSBundle:CityCountyState:form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
