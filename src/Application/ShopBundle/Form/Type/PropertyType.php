<?php
namespace Application\ShopBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Form for properties
 */
class PropertyType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('is_active', 'checkbox', array(
                'label' => 'property.active',
            ))

            ->add('type', 'choice', array(
                'label'       => 'property.type',
                'choices'     => \Application\ShopBundle\Entity\PropertyType::getChoices(),
                'empty_value' => 'property.select_type',
            ))

            ->add('name', 'text', array(
                'label' => 'property.name',
            ))

            ->add('label', 'text', array(
                'label' => 'property.label',
            ))

            ->add('is_required', 'checkbox', array(
                'label' => 'property.required',
            ))

            ->add('choices', 'collection', array(
                'required'     => false,
                'type'         => new PropertyChoiceType(),
                'allow_add'    => true,
                'allow_delete' => true,
                'by_reference' => false
            ));

        //listener
        $builder->addEventListener(\Symfony\Component\Form\FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $property = $event->getData();
            $property->setDataType(\Application\ShopBundle\Entity\PropertyType::getDataType($property->getType()));
        });
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Application\ShopBundle\Entity\Property',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'property';
    }
}
