<?php

namespace Lthrt\CCSBundle\Controller\Traits;

use Lthrt\CCSBundle\Entity\City;
use Lthrt\CCSBundle\Form\CityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * CityFormController Trait.
 */
trait CityFormTrait
{
    /**
     * Creates a form to delete a City entity by id.
     *
     * @param mixed $city The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(City $city)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('city', ['city' => $city->getId()]))
            ->setMethod('DELETE')
            ->add('submit', SubmitType::class, ['label' => 'Delete'])
            ->getForm();
    }

    /**
     * Creates a form to edit a City entity.
     *
     * @param City $city The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(City $city = null)
    {
        if ($city->getId()) {
            $form = $this->createForm(CityType::class, $city, [
                'action' => $this->generateUrl('city', ['city' => $city->getId()]),
                'method' => 'PUT',
            ]);

            return $form;
        } else {
            $form = $this->createForm(CityType::class, new City(), [
                'action' => $this->generateUrl('city_new'),
                'method' => 'PUT',
            ]);

            return $form;
        }
    }
}
