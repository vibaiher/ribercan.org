<?php

namespace Ribercan\DogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Ribercan\Admin\DogBundle\Entity\Dog;

class DogFilterType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
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
            ->add('years_old')
            ->add(
                'size',
                'choice',
                array(
                    'expanded' => true,
                    'multiple' => false,
                    'choices' => array(
                        'Pequeño' => Dog::SMALL,
                        'Mediano' => Dog::MEDIUM,
                        'Grande' => Dog::BIG,
                    ),
                    'choices_as_values' => true
                )
            )
            ->add('submit', 'submit', array('label' => 'Filter'))
        ;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ribercan_dogbundle_dog_search';
    }
}
