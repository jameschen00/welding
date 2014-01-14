<?php
namespace Application\GalleryBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class SectionType
 */
class SectionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Application\GalleryBundle\Entity\Section',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('is_active', 'checkbox', array('label' => 'banner.section.active'));
        $builder->add('name', 'text', array('label' => 'banner.section.name'));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'section';
    }
}
