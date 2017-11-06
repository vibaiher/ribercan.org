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
                    'label' => 'dog_filter.sex',
                    'required' => false,
                    'multiple' => false,
                    'choices' => array(
                        'dog_filter.any' => '',
                        'dog_filter.male' => Dog::MALE,
                        'dog_filter.female' => Dog::FEMALE
                    )
                )
            )
            ->add(
                'age',
                ChoiceType::class,
                array(
                    'label' => 'dog_filter.age',
                    'required' => false,
                    'multiple' => false,
                    'choices' => array(
                        'dog_filter.any' => '',
                        'dog_filter.puppy' => Dog::PUPPY,
                        'dog_filter.adult' => Dog::ADULT
                    )
                )
            )
            ->add(
                'size',
                ChoiceType::class,
                array(
                    'label' => 'dog_filter.size',
                    'required' => false,
                    'multiple' => false,
                    'choices' => array(
                        'dog_filter.any' => '',
                        'dog_filter.small' => Dog::SMALL,
                        'dog_filter.medium' => Dog::MEDIUM,
                        'dog_filter.big' => Dog::BIG,
                    )
                )
            )
            ->add(
                'submit',
                SubmitType::class,
                array(
                    'label' => 'dog_filter.filter',
                    'attr' => array(
                        'class' => 'btn btn--primary'
                    )
                )
            )
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
