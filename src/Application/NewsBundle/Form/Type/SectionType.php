<?php
namespace Application\NewsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Form for section
 */
class SectionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Application\NewsBundle\Entity\Section',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('active', 'checkbox', array('label' => 'news.section.active'));
        $builder->add('name', 'text', array('label' => 'news.section.name'));
        $builder->add('slug', 'text', array('label' => 'news.section.slug'));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'section';
    }
}
