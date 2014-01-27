<?php
namespace Application\GalleryBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class ImageType
 */
class ImageType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Application\GalleryBundle\Entity\Image',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('active', 'checkbox', array(
            'label' => 'gallery.image.active'
        ));

        $builder->add('name', 'text', array(
            'label' => 'gallery.image.name'
        ));

        $builder->add('description', 'textarea', array(
            'label' => 'gallery.image.description'
        ));

        $builder->add('section', 'entity', array(
            'label' => 'gallery.image.section',
            'class' => 'ApplicationGalleryBundle:Section'
        ));

        $builder->add('file', 'image', array('label' => 'gallery.image.file'));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'gallery_image';
    }
}
