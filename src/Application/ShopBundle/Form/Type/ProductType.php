<?php
namespace Application\ShopBundle\Form\Type;

use Application\ShopBundle\Entity\ProductPropertyValue;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Form for prototype
 */
class ProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('active', 'checkbox', array(
                'label'    => 'product.active',
                'required' => false
            ))

            ->add('name', 'text', array(
                'label' => 'product.name',
            ))

            ->add('model', 'text', array(
                'label' => 'product.model',
            ))

            ->add('slug', 'text', array(
                'label' => 'product.slug',
            ))

            ->add('prototype', 'entity', array(
                'class' => 'ApplicationShopBundle:Prototype',
                'label' => 'product.prototype',
            ))

            ->add('category', 'entity', array(
                'class'       => 'ApplicationShopBundle:Category',
                'label'       => 'product.category',
                'empty_value' => 'product.select_category',
            ))

            ->add('brand', 'entity', array(
                'class'       => 'ApplicationShopBundle:Brand',
                'label'       => 'product.brand',
                'empty_value' => 'product.select_brand',
            ))

            ->add('short_description', 'textarea', array(
                'label'    => 'product.short_description',
                'required' => false
            ))

            ->add('full_description', 'textarea', array(
                'label'    => 'product.full_description',
                'required' => false
            ))

            ->add('meta_title', 'text', array(
                'label'    => 'product.meta_title',
                'required' => false
            ))

            ->add('meta_description', 'text', array(
                'label'    => 'product.meta_description',
                'required' => false
            ))

            ->add('meta_keywords', 'text', array(
                'label'    => 'product.meta_title',
                'required' => false
            ))

            ->add('image', 'collection', array(
                'label'        => 'product.images',
                'required'     => false,
                'type'         => new ProductGalleryType(),
                'allow_add'    => true,
                'allow_delete' => true,
                'by_reference' => false
            ))

            ->add('properties', 'collection', array(
                'label'        => false,
                'type'         => new ProductPropertiesType(),
                'required'     => false,
                'prototype'    => true,
                'allow_add'    => true,
                'by_reference' => false
            ));

        $this->setDefaultValuesProperties($builder);
    }

    /**
     * @param FormBuilderInterface $builder
     */
    private function setDefaultValuesProperties(FormBuilderInterface $builder)
    {
        //fill collection an empty properties
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $data = $event->getData();
            if ($data === null || $data->getPrototype() === null) {
                return;
            }

            $properties = $data->getPrototype()->getProperties();
            $values     = $data->getProperties();
            foreach ($properties as $property) {
                $exist = false;
                foreach ($values as $value) {
                    if ($value->getProperty()) {
                        if ($value->getProperty()->getId() == $property->getId()) {
                            $exist = true;
                            break;
                        }
                    }
                }

                if (!$exist) {
                    $class     = '\Application\ShopBundle\Entity\ProductProperty' . ucfirst($property->getDataType());
                    $propValue = new $class();
                    $propValue->setProperty($property);
                    $data->addProperty($propValue);
                }
            }
            $event->setData($data);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Application\ShopBundle\Entity\Product',
            'label'      => false
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'product';
    }
}
