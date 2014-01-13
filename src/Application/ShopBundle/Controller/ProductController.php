<?php
namespace Application\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Product page
 */
class ProductController extends Controller
{
    /**
     * @param integer $product
     * @param integer $category
     *
     * @return array
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function indexAction($product, $category)
    {
        //check category
        $managerCategory = $this->get('core_manager_factory')->get('shop_category');
        $managerCategory->setId($category);
        $managerCategory->where();
        $category = $managerCategory->findOne();
        if (empty($category)) {
            throw $this->createNotFoundException('The category does not exist');
        }

        //get product
        $manager = $this->get('core_manager_factory')->get('shop_product');
        $manager->setCategory($category);
        $manager->setSlug($product);
        $manager->where();
        $manager->order();
        $product = $manager->findOne();
        if (empty($product)) {
            throw $this->createNotFoundException('The product does not exist');
        }

        //crumbs
        $paths = $this->get('shop_service_tree')->getTree()->getBranchById($category->getId());
        $crumbs = $this->get("white_october_breadcrumbs");
        foreach ($paths as $parent) {
            if ($parent->getId() > 1) {
                $crumbs->addItem($parent->getName(), $this->get('router')->generate('category_'.$parent->getId()));
            }
        }
        $crumbs->addItem($product->getName());

        //render
        return $this->render('ApplicationShopBundle:Product:index.' . $this->get('request')->getRequestFormat() . '.twig',
            array(
                'product'  => $product,
                'category' => $category,
            )
        );
    }
}
