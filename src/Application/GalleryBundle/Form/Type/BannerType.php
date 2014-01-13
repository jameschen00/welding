<?php
namespace Application\GalleryBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Form for Gallerys
 */
class GalleryType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Application\GalleryBundle\Entity\Gallery',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('is_active', 'checkbox', array(
            'label' => 'Gallery.active'
        ));

        $builder->add('name', 'text', array(
            'label' => 'Gallery.name'
        ));

        $builder->add('place', 'entity', array(
            'label' => 'Gallery.place',
            'class' => 'ApplicationGalleryBundle:Place'
        ));

        $builder->add('url', 'url', array(
            'label' => 'Gallery.url'
        ));

        $builder->add('code', 'textarea', array(
            'label' => 'Gallery.code'
        ));

        $builder->add('file', 'file', array('label' => 'Gallery.file'));

        $builder->add('priority', 'number', array(
            'label' => 'Gallery.priority',
            'data'  => 500
        ));

        $builder->add('startDate', 'date', array(
            'label' => 'Gallery.code',
            'format' => 'dd-MM-yyyy',
            'empty_value' => array('year' => 'Year', 'month' => 'Month', 'day' => 'Day')
        ));
        $builder->add('stopDate', 'date', array(
            'label' => 'Gallery.code',
            'format' => 'dd-MM-yyyy',
            'empty_value' => array('year' => 'Year', 'month' => 'Month', 'day' => 'Day')
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Gallery';
    }
}
