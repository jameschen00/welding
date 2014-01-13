<?php

namespace Application\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Main page and main componets
 */
class DefaultController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('ApplicationWebBundle:Default:index.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function headerAction()
    {
        $tree = $this->get('shop_service_tree')->getTree();

        return $this->render('ApplicationWebBundle:Default:header.html.twig', array('tree' => $tree->tree(1)));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function footerAction()
    {
        $tree = $this->get('shop_service_tree')->getTree();

        return $this->render('ApplicationWebBundle:Default:footer.html.twig', array('tree' => $tree->tree(1)));
    }
}
