<?php
namespace Application\ShopBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Form for product image
 */
class ProductGalleryType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', 'hidden', array(
                'data' => 'image',
            ))
            ->add('description', 'textarea')

            ->add('ordering', 'hidden', array(
                'data' => 500
            ))

            ->add('file', 'file', array(
                'label' => 'product.image.src',
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Application\ShopBundle\Entity\ProductFile',
        ));
    }


    /**
     * @return string
     */
    public function getName()
    {
        return 'product_gallery_image';
    }
}
