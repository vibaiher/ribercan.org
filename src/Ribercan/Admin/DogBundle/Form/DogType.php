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
            ->add(
                'sex',
                'choice',
                array(
                    'choices' => array(
                        'Macho' => false,
                        'Hembra' => true
                    ),
                    'choices_as_values' => true
                )
            )
            ->add('birthday', 'date')
            ->add('joinDate', 'date')
            ->add(
                'health',
                'choice',
                array(
                    'expanded' => true,
                    'multiple' => false,
                    'choices' => array(
                        'Esterilizado' => "Se entrega esterilizado",
                        'Con compromiso de esterilización' => "Se entrega con compromiso de esterilización"
                    ),
                    'choices_as_values' => true
                )
            )
            ->add('godfather', 'text', array('required' => false, 'empty_data' => null))
            ->add('description', 'text', array('required' => false, 'empty_data' => null))
            ->add(
                'size',
                'choice',
                array(
                    'expanded' => true,
                    'multiple' => false,
                    'choices' => array(
                        'Cachorro' => "Cachorro",
                        'Pequeño' => "Pequeño",
                        'Mediano' => "Mediano",
                        'Grande' => "Grande",
                    ),
                    'choices_as_values' => true
                )
            )
            ->add('urgent')
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
