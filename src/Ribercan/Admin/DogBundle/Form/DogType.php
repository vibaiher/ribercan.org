<?php

namespace Ribercan\Admin\DogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DogType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('sex')
            ->add('birthday')
            ->add('joinDate')
            ->add('health')
            ->add('godfather')
            ->add('description')
            ->add('size')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ribercan\Admin\DogBundle\Entity\Dog'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ribercan_admin_dogbundle_dog';
    }
}
