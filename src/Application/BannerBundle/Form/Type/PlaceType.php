<?php
namespace Application\BannerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Form for places
 */
class PlaceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Application\BannerBundle\Entity\Place',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('active', 'checkbox', array('label' => 'place.active'));
        $builder->add('name', 'text', array('label' => 'place.name'));
        $builder->add('width', 'text', array('label' => 'place.width'));
        $builder->add('widthPercent', 'checkbox', array('label' => 'place.widthPercent'));
        $builder->add('height', 'text', array('label' => 'place.height'));
        $builder->add('heightPercent', 'checkbox', array('label' => 'place.heightPercent'));
        $builder->add('count', 'text', array('label' => 'place.count'));
        $builder->add('bseparator', 'text', array('label' => 'place.bseparator'));
        $builder->add('scontainer', 'text', array('label' => 'place.scontainer'));
        $builder->add('econtainer', 'text', array('label' => 'place.econtainer'));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'place';
    }
}
