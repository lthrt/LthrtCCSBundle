<?php

namespace Lthrt\CCSBundle\Form\Combo\Listener;

use Lthrt\CCSBundle\Form\Combo\ComboTrait\AddCityTrait;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class CitySubscriber implements EventSubscriberInterface
{
    use AddCityTrait;

    private $cityRep;
    private $options;

    public function __construct(
        $cityRep,
        $options
    ) {
        $this->cityRep = $cityRep;
        $this->options = $options;
    }

    public static function getSubscribedEvents()
    {
        return [FormEvents::POST_SUBMIT => 'postSubmit'];
    }

    public function postSubmitData(FormEvent $event)
    {
        $state = $event->getData();
        $form  = $event->getForm();

        $form->remove('city');
        $this->addCity($form, $this->options);
    }
}
