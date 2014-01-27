<?php
namespace Application\ShopBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Form for brands
 */
class BrandType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('active', 'checkbox', array('label' => 'brand.active'));
        $builder->add('name', 'text', array('label' => 'brand.name'));
        $builder->add('description', 'text', array('label' => 'brand.description'));
        $builder->add('slug', 'text', array('label' => 'brand.slug'));
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Application\ShopBundle\Entity\Brand',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'brand';
    }
}
