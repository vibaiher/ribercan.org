<?php

namespace Ribercan\Admin\DogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Ribercan\Admin\DogBundle\Entity\Dog;

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
            ->add(
                'sex',
                'choice',
                array(
                    'choices' => array(
                        'Macho' => Dog::MALE,
                        'Hembra' => Dog::FEMALE
                    ),
                    'choices_as_values' => true
                )
            )
            ->add('birthday', 'birthday')
            ->add('joinDate', 'date')
            ->add('sterilized')
            ->add('godfather', 'text', array('required' => false, 'empty_data' => null))
            ->add('description', 'text', array('required' => false, 'empty_data' => null))
            ->add(
                'size',
                'choice',
                array(
                    'expanded' => true,
                    'multiple' => false,
                    'choices' => array(
                        'Cachorro' => Dog::PUPPY,
                        'Pequeño' => Dog::SMALL,
                        'Mediano' => Dog::MEDIUM,
                        'Grande' => Dog::BIG,
                    ),
                    'choices_as_values' => true
                )
            )
            ->add('urgent')
            ->add('video')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function configureOptions(OptionsResolverInterface $resolver)
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
