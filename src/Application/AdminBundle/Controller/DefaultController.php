<?php

namespace Application\AdminBundle\Controller;

use Application\AdminBundle\Entity\AdminMenu;
use Application\AdminBundle\Entity\AdminMenuTranslation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Application\AdminBundle\Manager\MenuManager;
use Application\CoreBundle\Helper\TreeHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class DefaultController
 */
class DefaultController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Template()
     */
    public function indexAction()
    {
//        $em = $this->getDoctrine()->getManager();
//        $product = $this->getDoctrine()
//            ->getRepository('ApplicationAdminBundle:AdminMenu')
//            ->find(7);
//        echo $product->getTitle();
//        exit;
//
//        $em->persist($product);
//        $em->flush();
//
//        $product->setTitle('title de');
//        $product->addTranslation(new AdminMenuTranslation('lt', 'title', 'Maistas'));
//        $em->persist($product);
//        $em->flush();
//
//
//        print_r($product->getMenuId());
//        exit;
        return array();
    }

    /**
     * Header
     * @return \Symfony\Component\HttpFoundation\Response
     * @Template()
     */
    public function headerAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();

        return array('user' => $user);
    }

    /**
     * Footer
     * @return \Symfony\Component\HttpFoundation\Response
     * @Template()
     */
    public function footerAction()
    {
        return array();
    }

    /**
     * Top menu
     * @return \Symfony\Component\HttpFoundation\Response
     * @Template()
     */
    public function menuAction()
    {
        $menu = $this->get('core_manager_factory')->get('admin_menu')->where()->order()->findAll();

        $active = array();
        $tree = new TreeHelper(array(
            'id' => 'menu_id',
            'pid' => 'menu_pid',
            'active' => $active,
            'data' => $menu
        ));
        $menu = $tree->tree();

        return array('menu' => $menu);
    }
}
