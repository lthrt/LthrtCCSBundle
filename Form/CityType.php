<?php

namespace Lthrt\CCSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CityType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(
        FormBuilderInterface $builder,
        array                $options
    ) {
        $builder
            ->add('active')
            ->add('name')
            ->add('county')
            ->add('state')
            ->add('zip');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Lthrt\CCSBundle\Entity\City',
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'lthrt_CCSBundle_city';
    }
}
