<?php

namespace Lthrt\CCSBundle\Form\Combo\Listener;

use Lthrt\CCSBundle\Form\Combo\ComboTrait\AddStateTrait;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class StateSubscriber implements EventSubscriberInterface
{
    use AddStateTrait;

    private $stateRep;
    private $options;

    public function __construct(
        $stateRep,
        $options
    ) {
        $this->stateRep = $stateRep;
        $this->options  = $options;
    }

    public static function getSubscribedEvents()
    {
        return [FormEvents::POST_SUBMIT => 'postSubmit'];
    }

    public function postSubmitData(FormEvent $event)
    {
        $state = $event->getData();
        $form  = $event->getForm();

        $form->remove('state');
        $this->addState($form, $this->options);
    }
}
