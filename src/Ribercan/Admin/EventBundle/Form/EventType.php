<?php

namespace Ribercan\Admin\EventBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Ribercan\EventBundle\Entity\Event;

class EventType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('summary', TextareaType::class)
            ->add('body', TextareaType::class)
            ->add('uploadedImage', FileType::class, array('data_class' => null, 'required' => false))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'data_class' => 'Ribercan\EventBundle\Entity\Event',
            'csrf_field_name' => 'event_token',
            'csrf_token_id'   => 'event'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ribercan_admin_eventsbundle_event';
    }
}
