<?php
namespace Application\ShopBundle\Controller;

use Application\CoreBundle\Library\Pagination\Adapter\ManagerAdapter;
use Application\CoreBundle\Library\Pagination\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Catalog list
 */
class CatalogController extends Controller
{
    /**
     * @param int $category
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function indexAction($category)
    {
        $managerCategory = $this->get('core_manager_factory')->get('shop_category');
        $managerCategory->setId($category);
        $managerCategory->where();
        $category = $managerCategory->findOne();
        if (empty($category)) {
            throw $this->createNotFoundException('The category does not exist');
        }

        //get child categories
        $categories = $this->get('shop_service_tree')->getTree()->childData($category->getId());

        //crumbs
        $this->get("white_october_breadcrumbs")->addItem($category->getName());

        //render
        return $this->render('ApplicationShopBundle:Catalog:index.' . $this->get('request')->getRequestFormat() . '.twig',
            array(
                'category'   => $category,
                'categories' => $categories,
            )
        );
    }

    /**
     * @param int $category
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function productsAction($category)
    {
        $managerCategory = $this->get('core_manager_factory')->get('shop_category');
        $managerCategory->setId($category);
        $managerCategory->where();
        $category = $managerCategory->findOne();
        if (empty($category)) {
            throw $this->createNotFoundException('The category does not exist');
        }

        //get list of products
        $manager = $this->get('core_manager_factory')->get('shop_product');
        $manager->setCategory($category);
        $manager->where();
        $manager->order();

        //pagination
        /* @var $paginator Paginator */
        $paginator = $this->get('core_paginator');
        $paginator->setAdapter(new ManagerAdapter($manager));
        $paginator->setPage($this->container->get('request')->get('page', 1));
        $products = $paginator->getItemsByPage();

        //get child categories
        $categories = $this->get('shop_service_tree')->getTree()->childData($category->getParent()->getId());

        //crumbs
        $paths = $this->get('shop_service_tree')->getTree()->getBranchById($category->getId());
        $crumbs = $this->get("white_october_breadcrumbs");
        foreach ($paths as $parent) {
            if ($parent->getId() > 1) {
                $crumbs->addItem($parent->getName(), $this->get('router')->generate('category_'.$parent->getId()));
            }
        }

        //render
        return $this->render('ApplicationShopBundle:Catalog:products.' . $this->get('request')->getRequestFormat() . '.twig',
            array(
                'products'   => $products,
                'category'   => $category,
                'categories' => $categories,
                'paginator'  => $paginator->render()
            )
        );
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function filterAction()
    {
        return $this->render('ApplicationShopBundle:Catalog:filter.html.twig', array('filter' => $this->get('shop_service_filter')));
    }

}
