<?php

namespace Lthrt\CCSBundle\Form\Combo;

use Lthrt\CCSBundle\Form\Combo\ComboTrait\AddCityTrait;
use Lthrt\CCSBundle\Form\Combo\ComboTrait\AddCountyTrait;
use Lthrt\CCSBundle\Form\Combo\ComboTrait\AddStateTrait;
use Lthrt\CCSBundle\Form\Combo\Listener\CitySubscriber;
use Lthrt\CCSBundle\Form\Combo\Listener\CountySubscriber;
use Lthrt\CCSBundle\Form\Combo\Listener\StateSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CityCountyStateCombo extends AbstractType
{
    use AddCityTrait;
    use AddCountyTrait;
    use AddStateTrait;

    private $cityRep;
    private $countyRep;
    private $options;
    private $stateRep;

    public function __construct(
        $em,
        $options
    ) {
        $this->options = array_merge(
            [
                'county' => null,
                'state'  => null,
                'city'   => null,
            ],
            $options
        );
        $this->cityRep   = $em->getRepository('LthrtCCSBundle:City');
        $this->countyRep = $em->getRepository('LthrtCCSBundle:County');
        $this->stateRep  = $em->getRepository('LthrtCCSBundle:State');
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(
        FormBuilderInterface $builder,
        array                $options
    ) {
        if (false !== $this->options['city']) {
            $this->addCity($builder, $this->options);
            $builder->get('city')->addEventSubscriber(
                new CitySubscriber($this->cityRep, $this->options)
            );
        }

        if (false !== $this->options['county']) {
            $this->addCounty($builder, $this->options);
            $builder->get('county')->addEventSubscriber(
                new CountySubscriber($this->countyRep, $this->options)
            );
        }

        if (false !== $this->options['state']) {
            $this->addState($builder, $this->options);
            $builder->get('state')->addEventSubscriber(
                new StateSubscriber($this->stateRep, $this->options)
            );
        }
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'lthrt_CCSBundle_citycountystate';
    }
}
