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
        //get list images
        $managerImage = $this->get('core_manager_factory')->get('gallery_image');
        $images = $managerImage->where()->order()->findAll();

        //get list of products
        $manager = $this->get('core_manager_factory')->get('shop_product');
        $manager->where();
        $manager->order();
        $manager->limit(20);
        $products = $manager->findAll();

        //render
        return $this->render('ApplicationWebBundle:Default:index.html.twig', array(
            'images'   => $images,
            'products' => $products,
        ));
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
