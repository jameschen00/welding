<?php
namespace Application\ShopBundle\Form\EventListener;

use Application\ShopBundle\Entity\PropertyType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

/**
 * Class PropertySubsriber
 */
class PropertySubscriber implements EventSubscriberInterface
{
    /**
     * @var \Symfony\Component\Form\FormFactoryInterface
     */
    private $factory;

    /**
     * @var array
     */
    private $options;

    /**
     * @param FormFactoryInterface $factory
     * @param array                $options
     */
    public function __construct(FormFactoryInterface $factory, $options = array())
    {
        $this->factory = $factory;
        $this->options = $options;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        // Tells the dispatcher that we want to listen on the form.pre_set_data
        // event and that the preSetData method should be called.
        return array(FormEvents::PRE_SET_DATA => 'preSetData');
    }

    /**
     * {@inheritdoc}
     */
    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();
        if (null === $data) {
            return;
        }

        $this->createValueField($data, $form);
    }

    /**
     * @param mixed         $data
     * @param FormInterface $form
     * @param string        $fieldName
     */
    public function createValueField($data, FormInterface $form, $fieldName = 'value')
    {
        $property = $data->getProperty();
        $type     = $property->getType();
        $value    = $data->getValue();

        $options = array(
            'auto_initialize' => false,
            'label'           => $property->getLabel(),
            'required'        => false
        );

        if ($property->getType() == 'separator') {
            $type = 'text';
        }

        if ($property->getType() === PropertyType::INPUT_CHOICE || $property->getType() === PropertyType::INPUT_MULTIPLE_CHOICE) {
            $options['choices'] = array();

            if ($property->getType() === PropertyType::INPUT_MULTIPLE_CHOICE) {
                $options['multiple'] = true;
                $type                = 'choice';
                $value               = (array) $value;
            } else {
                $value = is_array($value) ? $value[0] : $value;
            }
            foreach ($property->getChoices() as $choice) {
                $options['choices'][$choice->getChoiceId()] = $choice->getValue();
            }
        }

        $form->add($this->factory->createNamed($fieldName, $type, $value, $options));
    }
}