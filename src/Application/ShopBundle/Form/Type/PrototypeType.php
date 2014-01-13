<?php
namespace Application\ShopBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Form for prototype
 */
class PrototypeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'label' => 'prototype.name',
            ))

            ->add('properties', 'entity', array(
                'class' =>  'ApplicationShopBundle:Property',
                'label' => 'prototype.properties',
                'multiple' => true
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Application\ShopBundle\Entity\Prototype',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'prototype';
    }
}
