<?php

namespace Lthrt\CCSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ZipType extends AbstractType
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
            ->add('zip')
            ->add('active')
            ->add('city')
            ->add('county')
            ->add('state');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Lthrt\CCSBundle\Entity\Zip',
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'lthrt_CCSBundle_zip';
    }
}
