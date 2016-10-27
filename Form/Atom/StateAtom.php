<?php

namespace Lthrt\CCSBundle\Form\Atom;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class StateAtom extends AbstractType
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
                'class'        => 'LthrtCCSBundle:State',
                'label'        => 'State',
                'placeholder'  => '',
                'choice_label' => 'abbr',
            ]
        );
    }

    public function getParent()
    {
        return 'entity';
    }

    /**
     * @return unknown
     */
    public function getName()
    {
        return 'state';
    }
}
