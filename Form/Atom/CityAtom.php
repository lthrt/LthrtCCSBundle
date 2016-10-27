<?php

namespace Lthrt\CCSBundle\Form\Atom;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CityAtom extends AbstractType
{
    private $em;
    private $tokenStorage;

    public function __construct(
        $em,
        $tokenStorage
    ) {
        $this->em           = $em;
        $this->tokenStorage = $tokenStorage;
    }

    public function buildForm(
        FormBuilderInterface $builder,
        array                $options
    ) {}
    /**
     * @param object $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'class'       => 'LthrtCCSBundle:City',
                'label'       => 'City',
                'placeholder' => '',
            ]
        );
    }

    public function getParent()
    {
        return 'choice';
    }

    /**
     * @return unknown
     */
    public function getName()
    {
        return 'city';
    }
}
