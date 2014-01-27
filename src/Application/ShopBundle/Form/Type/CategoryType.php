<?php
namespace Application\ShopBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Form for category
 */
class CategoryType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('active', 'checkbox', array(
                'label' => 'category.active',
            ))

            ->add('parent', 'entity', array(
                'class' =>  'ApplicationShopBundle:Category',
                'label' => 'category.parent',
                'empty_value' => 'category.select_parent',
            ))

            ->add('name', 'text', array(
                'label' => 'category.name',
            ))

            ->add('slug', 'text', array(
                'label' => 'category.url',
            ))

            ->add('ordering', 'text', array(
                'label' => 'category.ordering',
            ))

            ->add('prototype', 'entity', array(
                'class' =>  'ApplicationShopBundle:Prototype',
                'label' => 'category.prototype',
                'empty_value' => 'category.select_prototype',
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'category';
    }
}
