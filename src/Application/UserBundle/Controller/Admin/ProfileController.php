<?php
namespace Application\UserBundle\Controller\Admin;

use Application\UserBundle\Form\Admin\ProfileForm;
use Application\UserBundle\Manager\UserManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * User profile
 */
class ProfileController extends Controller
{
    /**
     * @Template
     * @return Response
     */
    public function indexAction()
    {
        $userId = $this->get('security.context')->getToken()->getUser()->getId();

        //get data
        $manager = new UserManager($this->getDoctrine()->getManager());
        $manager->setId($userId);
        $user = $manager->findOne();

        //create form
        $form = $this->createForm(new ProfileForm(), $user);

        //save
        if ($this->getRequest()->isMethod('POST')) {
            $form->handleRequest($this->getRequest());
            if ($form->isValid()) {
                $manager->save($user);

                //notice
                $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('Your changes were saved!'));

                //redirect
                return $this->redirect($this->generateUrl($this->getRequest()->attributes->get('_route')));
            } else {
                //notice
                $this->get('session')->getFlashBag()->add('notice', $this->get('translator')->trans('Error while saving data!'));
            }
        }

        return array('form' => $form->createView());
    }
}
