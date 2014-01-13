<?php
namespace Application\UserBundle\Controller\Admin;

use Application\UserBundle\Manager\PasswordManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Restore password
 * @Route("/password")
 */
class PasswordController extends Controller
{
    /**
     * @Route("/", name="restore_password")
     * @Template
     */
    public function indexAction()
    {
        //create form
        $builder = $this->createFormBuilder(null, array(
            'render_fieldset' => false,
            'show_legend' => false,
        ));
        $builder->add('email', 'email', array(
            'label' => 'user.email',
            'widget_type' => "inline",
            'attr' => array(
                'placeholder' => "E-mail",
            )
        ));
        $form = $builder->getForm();

        //save
        if ($this->getRequest()->isMethod('POST')) {
            $form->handleRequest($this->getRequest());
            if ($form->isValid()) {

                //start restore
                $manager = new PasswordManager($this->container);
                $manager->start($form->get('email')->getData());

                //redirect
                return $this->redirect($this->generateUrl('restore_send'));
            } else {
                $this->get('session')->getFlashBag()->add('notice', $this->get('translator')->trans('page.restore.error'));

                return $this->redirect($this->generateUrl('restore_password'));
            }
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/send", name="restore_send")
     * @Template
     */
    public function sendAction()
    {
        return array();
    }

    /**
     * @Route("/restore/{hash}", name="restore_public")
     *
     * @Template
     */
    public function restoreAction($hash)
    {
        $managerPassword = new PasswordManager($this->container);
        if (!($user = $managerPassword->check($hash))) {
            return $this->createNotFoundException($this->get('translator')->trans('page.restore.wrong_hash'));
        }

        //create form
        $builder = $this->createFormBuilder(null, array(
            'render_fieldset' => false,
            'show_legend' => false,
        ));
        $builder->add('user_password', 'repeated', array(
            'type' => 'password',
            'invalid_message' => 'The password fields must match.',
            'options' => array('attr' => array('class' => 'password-field')),
            'required' => true,
            'first_options' => array('label' => 'user.password'),
            'second_options' => array('label' => 'user.repeatpassword')
        ));
        $form = $builder->getForm();

        //save
        if ($this->getRequest()->isMethod('POST')) {
            $form->handleRequest($this->getRequest());
            if ($form->isValid()) {
                //change password
                $managerPassword->change($hash, $form->get('user_password')->getData());

                //redirect
                return $this->redirect($this->generateUrl('restore_success'));
            } else {
                return $this->redirect($this->generateUrl('restore_public', array('hash' => $hash)));
            }
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/success", name="restore_success")
     *
     * @Template
     */
    public function successAction()
    {
        return array();
    }
}
