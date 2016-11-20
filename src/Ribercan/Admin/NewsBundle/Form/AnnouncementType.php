<?php

namespace Ribercan\Admin\NewsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Ribercan\NewsBundle\Entity\Announcement;

class AnnouncementType extends AbstractType
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
            'data_class' => 'Ribercan\NewsBundle\Entity\Announcement',
            'csrf_field_name' => 'announcement_token',
            'csrf_token_id'   => 'announcement'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ribercan_admin_newsbundle_announcement';
    }
}
