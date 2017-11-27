<?php

namespace Ribercan\Admin\DogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DogImageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'uploadedImages',
                FileType::class,
                array(
                    'label' => 'Upload image(s)',
                    'multiple' => true,
                    'data_class' => null,
                    'required' => true
                )
            )
            ->add(
                'Upload',
                SubmitType::class,
                array(
                    'label' => 'Upload',
                    'attr' => array(
                        'class' => 'btn btn-primary'
                    )
                )
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ribercan\Admin\DogBundle\Entity\Dog',
            'csrf_field_name' => 'dog_image_token',
            'csrf_token_id'   => 'dog_image'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ribercan_admin_dogbundle_dog_image';
    }
}
