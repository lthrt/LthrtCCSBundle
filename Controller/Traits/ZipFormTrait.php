<?php

namespace Lthrt\CCSBundle\Controller\Traits;

use Lthrt\CCSBundle\Entity\Zip;
use Lthrt\CCSBundle\Form\ZipType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * ZipFormController Trait.
 */
trait ZipFormTrait
{
    /**
     * Creates a form to delete a Zip entity by id.
     *
     * @param mixed $zip The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Zip $zip)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('zip', ['zip' => $zip->getId()]))
            ->setMethod('DELETE')
            ->add('submit', SubmitType::class, ['label' => 'Delete'])
            ->getForm();
    }

    /**
     * Creates a form to edit a Zip entity.
     *
     * @param Zip $zip The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Zip $zip = null)
    {
        if ($zip->getId()) {
            $form = $this->createForm(ZipType::class, $zip, [
                'action' => $this->generateUrl('zip', ['zip' => $zip->getId()]),
                'method' => 'PUT',
            ]);

            return $form;
        } else {
            $form = $this->createForm(ZipType::class, new Zip(), [
                'action' => $this->generateUrl('zip_new'),
                'method' => 'PUT',
            ]);

            return $form;
        }
    }
}
