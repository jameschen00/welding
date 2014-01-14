<?php
namespace Application\NewsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Form for Newss
 */
class NewsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Application\NewsBundle\Entity\News',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('is_active', 'checkbox', array(
            'label' => 'News.active'
        ));

        $builder->add('name', 'text', array(
            'label' => 'News.name'
        ));

        $builder->add('place', 'entity', array(
            'label' => 'News.place',
            'class' => 'ApplicationNewsBundle:Place'
        ));

        $builder->add('url', 'url', array(
            'label' => 'News.url'
        ));

        $builder->add('code', 'textarea', array(
            'label' => 'News.code'
        ));

        $builder->add('file', 'file', array('label' => 'News.file'));

        $builder->add('priority', 'number', array(
            'label' => 'News.priority',
            'data'  => 500
        ));

        $builder->add('startDate', 'date', array(
            'label' => 'News.code',
            'format' => 'dd-MM-yyyy',
            'empty_value' => array('year' => 'Year', 'month' => 'Month', 'day' => 'Day')
        ));
        $builder->add('stopDate', 'date', array(
            'label' => 'News.code',
            'format' => 'dd-MM-yyyy',
            'empty_value' => array('year' => 'Year', 'month' => 'Month', 'day' => 'Day')
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'News';
    }
}
