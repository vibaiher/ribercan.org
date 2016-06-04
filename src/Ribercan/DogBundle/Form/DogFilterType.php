<?php

namespace Ribercan\DogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

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
                ChoiceType::class,
                array(
                    'choices' => array(
                        'Macho' => Dog::MALE,
                        'Hembra' => Dog::FEMALE
                    )
                )
            )
            ->add(
                'years_old',
                IntegerType::class
            )
            ->add(
                'size',
                ChoiceType::class,
                array(
                    'expanded' => true,
                    'multiple' => false,
                    'choices' => array(
                        'Pequeño' => Dog::SMALL,
                        'Mediano' => Dog::MEDIUM,
                        'Grande' => Dog::BIG,
                    )
                )
            )
            ->add('submit', SubmitType::class, array('label' => 'Filter'))
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
