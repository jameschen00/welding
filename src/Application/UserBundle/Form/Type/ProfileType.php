<?php
namespace Application\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Admin user profile form
 *
 * Class ProfileForm
 */
class ProfileType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Application\UserBundle\Entity\User',
            'bind_errors' => true
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstname', 'text', array(
            'label' => 'user.firstname',
        ));

        $builder->add('lastname', 'text', array(
            'label' => 'user.lastname',
        ));

        $builder->add('email', 'email', array(
            'label' => 'user.email',
        ));

        $builder->add('user_password', 'repeated', array(
            'type'            => 'password',
            'invalid_message' => 'The password fields must match.',
            'options'         => array('attr' => array('class' => 'password-field')),
            'required'        => false,
            'first_options'   => array('label' => 'user.password'),
            'second_options'  => array('label' => 'user.repeatpassword'),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'profile';
    }
}
