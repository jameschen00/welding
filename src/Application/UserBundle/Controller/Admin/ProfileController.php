<?php
namespace Application\UserBundle\Controller\Admin;

use Application\UserBundle\Form\Type\ProfileType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * User profile
 */
class ProfileController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function indexAction(Request $request)
    {
        $userId = $this->get('security.context')->getToken()->getUser()->getId();

        //get data
        $manager = $this->get('core_manager_factory')->get('user_user');
        $manager->setId($userId);
        $user = $manager->findOne();

        //create form
        $form = $this->createForm(new ProfileType(), $user);

        //save
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $manager->save($user);

                //notice
                $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('Your changes were saved!'));

                //redirect
                return $this->redirect($this->generateUrl($request->attributes->get('_route')));
            } else {
                //notice
                $this->get('session')->getFlashBag()->add('notice', $this->get('translator')->trans('Error while saving data!'));
            }
        }

        return $this->render('ApplicationUserBundle:Admin/Profile:index.html.twig', array('form' => $form->createView()));
    }
}
