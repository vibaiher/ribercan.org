<?php

namespace Ribercan\Admin\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Ribercan\ShopBundle\Entity\Product;

class ProductType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('description', TextareaType::class)
            ->add('price', TextareaType::class)
            ->add(
                'price',
                MoneyType::class,
                array(
                    'currency' => 'EUR'
                )
            )
            ->add('uploadedImages', FileType::class, array('multiple' => true, 'data_class' => null, 'required' => false))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ribercan\ShopBundle\Entity\Product',
            'csrf_field_name' => 'product_token',
            'csrf_token_id'   => 'product'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ribercan_admin_shopbundle_product';
    }
}
