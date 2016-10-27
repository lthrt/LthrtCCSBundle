<?php

namespace Lthrt\CCSBundle\Controller;

use Lthrt\CCSBundle\Entity\County;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * County controller.
 *
 * @Route("/admin/county")
 */
class CountyController extends Controller
{
    use \Lthrt\CCSBundle\Controller\Traits\CountyFormTrait;
    use \Lthrt\CCSBundle\Controller\Traits\CountyNotFoundTrait;

    /**
     * Gets edit form existing County entity.
     *
     * @Route("/{county}/edit", name="county_edit")
     *
     * @Method({"GET"})
     * @Template("LthrtCCSBundle:County:edit.html.twig")
     */
    public function editAction(
        Request $request,
        County  $county
    ) {
        $this->notFound($county);

        $form       = $this->createEditForm($county);
        $deleteForm = $this->createDeleteForm($county);

        return [
            'county'      => $county,
            'form'        => $form->createView(),
            'delete_form' => $deleteForm->createView(),
        ];
    }

    /**
     * Lists all County entities.
     *
     * @Route("/", name="county_list")
     *
     * @Method("GET")
     * @Template("LthrtCCSBundle:County:index.html.twig")
     */
    public function indexAction(Request $request)
    {
        $countyCollection = $this->getDoctrine()->getManager()->getRepository('LthrtCCSBundle:County')->findAll();

        return [
            'countyCollection' => $countyCollection,
        ];
    }

    /**
     * Routing for BackBone API for existing County entity.
     * Handles show, update and delete
     * action on a 'single' entity.
     *
     * @Route("/{county}", name="county", requirements={"county":"\d+"})
     *
     * @Method({"DELETE","GET","PUT"})
     * @Template("LthrtCCSBundle:County:edit.html.twig")
     */
    public function singleAction(
        Request $request,
        County  $county
    ) {
        $this->notFound($county);

        if ($request->isMethod('GET')) {
            return $this->forward('LthrtCCSBundle:County:show', ['county' => $county]);
        } else {
            // Method is PUT or DELETE
            $form       = $this->createEditForm($county);
            $deleteForm = $this->createDeleteForm($county);
            $form->handleRequest($request);
            $em = $this->getDoctrine()->getManager();
            if ($request->isMethod('PUT')) {
                if ($form->isValid() && $form->isSubmitted()) {
                    $em->persist($county);
                    $em->flush();

                    return $this->forward('LthrtCCSBundle:County:show', ['county' => $county]);
                } else {
                    return $this->render('LthrtCCSBundle:County:edit.html.twig', [
                        'county'      => $county,
                        'form'        => $form->createView(),
                        'delete_form' => $deleteForm->createView(),
                    ]);
                }
            } else {
                if ($request->isMethod('DELETE')) {
                    if ($form->isValid() && $form->isSubmitted()) {
                        $em->remove($county);
                        $em->flush();

                        return $this->forward($this->generateUrl('county'));
                    } else {
                        return $this->forward('LthrtCCSBundle:County:show', ['county' => $county]);
                    }
                }
            }
        }
    }

    /**
     * Creates a new County entity.
     *
     * @Route("/new", name="county_new")
     *
     * @Method({"GET", "POST"})
     * @Template("LthrtCCSBundle:County:new.html.twig")
     */
    public function newAction(Request $request)
    {
        $county = new County();
        $form   = $this->createEditForm($county);
        $form->handleRequest($request);
        if (
            $request->isMethod('POST') &&
            $form->isValid() &&
            $form->isSubmitted()
        ) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($county);
            $em->flush();

            return $this->redirect($this->generateUrl('county_show', ['county' => $county->getId()]));
        }

        return [
            'county' => $county,
            'form'   => $form->createView(),
        ];
    }

    /**
     * Finds and displays a County entity.
     *
     * @Route("/{county}/show", name="county_show")
     *
     * @Method("GET")
     * @Template("LthrtCCSBundle:County:show.html.twig")
     */
    public function showAction(
        Request $request,
        County  $county
    ) {
        $this->notFound($county);

        $deleteForm = $this->createDeleteForm($county);

        return [
            'county'      => $county,
            'delete_form' => $deleteForm->createView(),
        ];
    }
}
