<?php

namespace Lthrt\CCSBundle\Controller;

use Lthrt\CCSBundle\Entity\City;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * City controller.
 *
 * @Route("/admin/city")
 */
class CityController extends Controller
{
    use \Lthrt\CCSBundle\Controller\Traits\CityFormTrait;
    use \Lthrt\CCSBundle\Controller\Traits\CityNotFoundTrait;

    /**
     * Gets edit form existing City entity.
     *
     * @Route("/{city}/edit", name="city_edit")
     *
     * @Method({"GET"})
     * @Template("LthrtCCSBundle:City:edit.html.twig")
     */
    public function editAction(
        Request $request,
        City    $city
    ) {
        $this->notFound($city);

        $form       = $this->createEditForm($city);
        $deleteForm = $this->createDeleteForm($city);

        return [
            'city'        => $city,
            'form'        => $form->createView(),
            'delete_form' => $deleteForm->createView(),
        ];
    }

    /**
     * Lists all City entities.
     *
     * @Route("/", name="city_list")
     *
     * @Method("GET")
     * @Template("LthrtCCSBundle:City:index.html.twig")
     */
    public function indexAction(Request $request)
    {
        $cityCollection = $this->getDoctrine()->getManager()->getRepository('LthrtCCSBundle:City')->findAll();

        return [
            'cityCollection' => $cityCollection,
        ];
    }

    /**
     * Routing for BackBone API for existing City entity.
     * Handles show, update and delete
     * action on a 'single' entity.
     *
     * @Route("/{city}", name="city", requirements={"city":"\d+"})
     *
     * @Method({"DELETE","GET","PUT"})
     * @Template("LthrtCCSBundle:City:edit.html.twig")
     */
    public function singleAction(
        Request $request,
        City    $city
    ) {
        $this->notFound($city);

        if ($request->isMethod('GET')) {
            return $this->forward('LthrtCCSBundle:City:show', ['city' => $city]);
        } else {
            // Method is PUT or DELETE
            $form       = $this->createEditForm($city);
            $deleteForm = $this->createDeleteForm($city);
            $form->handleRequest($request);
            $em = $this->getDoctrine()->getManager();
            if ($request->isMethod('PUT')) {
                if ($form->isValid() && $form->isSubmitted()) {
                    $em->persist($city);
                    $em->flush();

                    return $this->forward('LthrtCCSBundle:City:show', ['city' => $city]);
                } else {
                    return $this->render('LthrtCCSBundle:City:edit.html.twig', [
                        'city'        => $city,
                        'form'        => $form->createView(),
                        'delete_form' => $deleteForm->createView(),
                    ]);
                }
            } else {
                if ($request->isMethod('DELETE')) {
                    if ($form->isValid() && $form->isSubmitted()) {
                        $em->remove($city);
                        $em->flush();

                        return $this->forward($this->generateUrl('city'));
                    } else {
                        return $this->forward('LthrtCCSBundle:City:show', ['city' => $city]);
                    }
                }
            }
        }
    }

    /**
     * Creates a new City entity.
     *
     * @Route("/new", name="city_new")
     *
     * @Method({"GET", "POST"})
     * @Template("LthrtCCSBundle:City:new.html.twig")
     */
    public function newAction(Request $request)
    {
        $city = new City();
        $form = $this->createEditForm($city);
        $form->handleRequest($request);
        if (
            $request->isMethod('POST') &&
            $form->isValid() &&
            $form->isSubmitted()
        ) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($city);
            $em->flush();

            return $this->redirect($this->generateUrl('city_show', ['city' => $city->getId()]));
        }

        return [
            'city' => $city,
            'form' => $form->createView(),
        ];
    }

    /**
     * Finds and displays a City entity.
     *
     * @Route("/{city}/show", name="city_show")
     *
     * @Method("GET")
     * @Template("LthrtCCSBundle:City:show.html.twig")
     */
    public function showAction(
        Request $request,
        City    $city
    ) {
        $this->notFound($city);

        $deleteForm = $this->createDeleteForm($city);

        return [
            'city'        => $city,
            'delete_form' => $deleteForm->createView(),
        ];
    }
}
