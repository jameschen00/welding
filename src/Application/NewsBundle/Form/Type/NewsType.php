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
        $builder->add('active', 'checkbox', array(
            'label' => 'news.item.active'
        ));

        $builder->add('title', 'text', array(
            'label' => 'news.item.title'
        ));

        $builder->add('section', 'entity', array(
            'label' => 'news.item.section',
            'class' => 'ApplicationNewsBundle:Section'
        ));

        $builder->add('short_text', 'textarea', array(
            'label' => 'news.item.short_text'
        ));

        $builder->add('full_text', 'textarea', array(
            'label' => 'news.item.full_text'
        ));

        $builder->add('file', 'image', array('label' => 'news.item.file'));

        $builder->add('startDate', 'date', array(
            'label'       => 'news.item.startDate',
            'format'      => 'dd-MM-yyyy',
            'empty_value' => array('year' => 'Year', 'month' => 'Month', 'day' => 'Day')
        ));
        $builder->add('stopDate', 'date', array(
            'label'       => 'news.item.stopDate',
            'format'      => 'dd-MM-yyyy',
            'empty_value' => array('year' => 'Year', 'month' => 'Month', 'day' => 'Day')
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'news';
    }
}
