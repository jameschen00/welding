<?php
namespace Application\AdminBundle\Controller;

use Application\AdminBundle\Entity\AdminMenuTranslation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class DefaultController
 */
class DefaultController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('ApplicationAdminBundle:Default:index.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function headerAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();

        return $this->render('ApplicationAdminBundle:Default:header.html.twig', array('user' => $user));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function footerAction()
    {
        return $this->render('ApplicationAdminBundle:Default:footer.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function menuAction()
    {
        return $this->render('ApplicationAdminBundle:Default:menu.html.twig');
    }
}
