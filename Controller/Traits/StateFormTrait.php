<?php

namespace Lthrt\CCSBundle\Controller\Traits;

use Lthrt\CCSBundle\Entity\State;
use Lthrt\CCSBundle\Form\StateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * StateFormController Trait.
 */
trait StateFormTrait
{
    /**
     * Creates a form to delete a State entity by id.
     *
     * @param mixed $state The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(State $state)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('state', ['state' => $state->getId()]))
            ->setMethod('DELETE')
            ->add('submit', SubmitType::class, ['label' => 'Delete'])
            ->getForm();
    }

    /**
     * Creates a form to edit a State entity.
     *
     * @param State $state The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(State $state = null)
    {
        if ($state->getId()) {
            $form = $this->createForm(StateType::class, $state, [
                'action' => $this->generateUrl('state', ['state' => $state->getId()]),
                'method' => 'PUT',
            ]);

            return $form;
        } else {
            $form = $this->createForm(StateType::class, new State(), [
                'action' => $this->generateUrl('state_new'),
                'method' => 'PUT',
            ]);

            return $form;
        }
    }
}
