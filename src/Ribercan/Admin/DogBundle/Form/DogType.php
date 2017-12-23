<?php

namespace Ribercan\Admin\DogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

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
            ->add('description', TextareaType::class, array('required' => false, 'empty_data' => null))
            ->add(
                'sex',
                ChoiceType::class,
                array(
                    'multiple' => false,
                    'choices' => array(
                        'Macho' => Dog::MALE,
                        'Hembra' => Dog::FEMALE
                    )
                )
            )
            ->add('birthday', BirthdayType::class)
            ->add('joinDate', BirthdayType::class)
            ->add('sterilized')
            ->add('health', TextareaType::class, array('required' => false, 'empty_data' => null))
            ->add('godfather', TextType::class, array('required' => false, 'empty_data' => null))
            ->add(
                'size',
                ChoiceType::class,
                array(
                    'multiple' => false,
                    'choices' => array(
                        'Pequeño' => Dog::SMALL,
                        'Mediano' => Dog::MEDIUM,
                        'Grande' => Dog::BIG,
                    )
                )
            )
            ->add('urgent')
            ->add('video')
            ->add('uploadedImages', FileType::class, array('multiple' => true, 'data_class' => null, 'required' => false))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ribercan\Admin\DogBundle\Entity\Dog',
            'csrf_field_name' => 'dog_token',
            'csrf_token_id'   => 'dog'
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
