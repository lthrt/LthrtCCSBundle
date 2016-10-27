<?php

namespace Lthrt\CCSBundle\Form\Combo\Listener;

use Lthrt\CCSBundle\Form\Combo\ComboTrait\AddCountyTrait;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class CountySubscriber implements EventSubscriberInterface
{
    use AddCountyTrait;

    private $countyRep;
    private $options;

    public function __construct(
        $countyRep,
        $options
    ) {
        $this->countyRep = $countyRep;
        $this->options   = $options;
    }

    public static function getSubscribedEvents()
    {
        return [FormEvents::POST_SUBMIT => 'postSubmit'];
    }

    public function postSubmitData(FormEvent $event)
    {
        $state = $event->getData();
        $form  = $event->getForm();

        $form->remove('county');
        $this->addCounty($form, $this->options);
    }
}
