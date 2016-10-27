<?php

namespace Lthrt\CCSBundle\Controller;

use Lthrt\CCSBundle\Entity\Zip;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Zip controller.
 *
 * @Route("/admin/zip")
 */
class ZipController extends Controller
{
    use \Lthrt\CCSBundle\Controller\Traits\ZipFormTrait;
    use \Lthrt\CCSBundle\Controller\Traits\ZipNotFoundTrait;

    /**
     * Gets edit form existing Zip entity.
     *
     * @Route("/{zip}/edit", name="zip_edit")
     *
     * @Method({"GET"})
     * @Template("LthrtCCSBundle:Zip:edit.html.twig")
     */
    public function editAction(
        Request $request,
        Zip     $zip
    ) {
        $this->notFound($zip);

        $form       = $this->createEditForm($zip);
        $deleteForm = $this->createDeleteForm($zip);

        return [
            'zip'         => $zip,
            'form'        => $form->createView(),
            'delete_form' => $deleteForm->createView(),
        ];
    }

    /**
     * Lists all Zip entities.
     *
     * @Route("/", name="zip_list")
     *
     * @Method("GET")
     * @Template("LthrtCCSBundle:Zip:index.html.twig")
     */
    public function indexAction(Request $request)
    {
        $zipCollection = $this->getDoctrine()->getManager()->getRepository('LthrtCCSBundle:Zip')->findAll();

        return [
            'zipCollection' => $zipCollection,
        ];
    }

    /**
     * Routing for BackBone API for existing Zip entity.
     * Handles show, update and delete
     * action on a 'single' entity.
     *
     * @Route("/{zip}", name="zip", requirements={"zip":"\d+"})
     *
     * @Method({"DELETE","GET","PUT"})
     * @Template("LthrtCCSBundle:Zip:edit.html.twig")
     */
    public function singleAction(
        Request $request,
        Zip     $zip
    ) {
        $this->notFound($zip);

        if ($request->isMethod('GET')) {
            return $this->forward('LthrtCCSBundle:Zip:show', ['zip' => $zip]);
        } else {
            // Method is PUT or DELETE
            $form       = $this->createEditForm($zip);
            $deleteForm = $this->createDeleteForm($zip);
            $form->handleRequest($request);
            $em = $this->getDoctrine()->getManager();
            if ($request->isMethod('PUT')) {
                if ($form->isValid() && $form->isSubmitted()) {
                    $em->persist($zip);
                    $em->flush();

                    return $this->forward('LthrtCCSBundle:Zip:show', ['zip' => $zip]);
                } else {
                    return $this->render('LthrtCCSBundle:Zip:edit.html.twig', [
                        'zip'         => $zip,
                        'form'        => $form->createView(),
                        'delete_form' => $deleteForm->createView(),
                    ]);
                }
            } else {
                if ($request->isMethod('DELETE')) {
                    if ($form->isValid() && $form->isSubmitted()) {
                        $em->remove($zip);
                        $em->flush();

                        return $this->forward($this->generateUrl('zip'));
                    } else {
                        return $this->forward('LthrtCCSBundle:Zip:show', ['zip' => $zip]);
                    }
                }
            }
        }
    }

    /**
     * Creates a new Zip entity.
     *
     * @Route("/new", name="zip_new")
     *
     * @Method({"GET", "POST"})
     * @Template("LthrtCCSBundle:Zip:new.html.twig")
     */
    public function newAction(Request $request)
    {
        $zip  = new Zip();
        $form = $this->createEditForm($zip);
        $form->handleRequest($request);
        if (
            $request->isMethod('POST') &&
            $form->isValid() &&
            $form->isSubmitted()
        ) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($zip);
            $em->flush();

            return $this->redirect($this->generateUrl('zip_show', ['zip' => $zip->getId()]));
        }

        return [
            'zip'  => $zip,
            'form' => $form->createView(),
        ];
    }

    /**
     * Finds and displays a Zip entity.
     *
     * @Route("/{zip}/show", name="zip_show")
     *
     * @Method("GET")
     * @Template("LthrtCCSBundle:Zip:show.html.twig")
     */
    public function showAction(
        Request $request,
        Zip     $zip
    ) {
        $this->notFound($zip);

        $deleteForm = $this->createDeleteForm($zip);

        return [
            'zip'         => $zip,
            'delete_form' => $deleteForm->createView(),
        ];
    }
}
