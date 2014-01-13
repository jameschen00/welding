<?php
namespace Application\BannerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Form for banners
 */
class BannerType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Application\BannerBundle\Entity\Banner',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('is_active', 'checkbox', array(
            'label' => 'banner.active'
        ));

        $builder->add('name', 'text', array(
            'label' => 'banner.name'
        ));

        $builder->add('place', 'entity', array(
            'label' => 'banner.place',
            'class' => 'ApplicationBannerBundle:Place'
        ));

        $builder->add('url', 'url', array(
            'label' => 'banner.url'
        ));

        $builder->add('code', 'textarea', array(
            'label' => 'banner.code'
        ));

        $builder->add('file', 'file', array('label' => 'banner.file'));

        $builder->add('priority', 'number', array(
            'label' => 'banner.priority',
            'data'  => 500
        ));

        $builder->add('startDate', 'date', array(
            'label' => 'banner.code',
            'format' => 'dd-MM-yyyy',
            'empty_value' => array('year' => 'Year', 'month' => 'Month', 'day' => 'Day')
        ));
        $builder->add('stopDate', 'date', array(
            'label' => 'banner.code',
            'format' => 'dd-MM-yyyy',
            'empty_value' => array('year' => 'Year', 'month' => 'Month', 'day' => 'Day')
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'banner';
    }
}
