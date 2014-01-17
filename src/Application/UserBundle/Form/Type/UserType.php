<?php
namespace Application\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Admin user form
 *
 * Class ProfileForm
 */
class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Application\UserBundle\Entity\User',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('is_active', 'checkbox', array(
            'label' => 'user.active',
        ));

        $builder->add('firstname', 'text', array(
            'label' => 'user.firstname',
        ));

        $builder->add('lastname', 'text', array(
            'label' => 'user.lastname',
        ));

        $builder->add('email', 'email', array(
            'label' => 'user.email',
        ));

        //password
        $builder->add('user_password', 'repeated', array(
            'type'            => 'password',
            'invalid_message' => 'The password fields must match.',
            'options'         => array('attr' => array('class' => 'password-field')),
            'required'        => false,
            'first_options'   => array('label' => 'user.password'),
            'second_options'  => array('label' => 'user.repeatpassword'),
        ));

        $builder->add('user_roles', 'entity', array(
            'label'    => 'user.roles',
            'class'    => 'ApplicationUserBundle:Role',
            'property' => 'name',
            'multiple' => true,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'user';
    }
}
