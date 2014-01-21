<?php
namespace Application\ShopBundle\Controller\Admin;

use Application\AdminBundle\Controller\Configuration;
use Application\ShopBundle\Form\Type\ProductType;
use Application\ShopBundle\Grid\Type\ProductType as ProductGrid;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Application\AdminBundle\Controller\AbstractAdminController;

/**
 * Product administration class
 *
 * @Route("/shop/product")
 */
class ProductController extends AbstractAdminController
{
    /**
     * {@inheritdoc}
     */
    protected function getConfiguration()
    {
        $configuration = new Configuration();
        $configuration->setManager('shop_product');
        $configuration->setTemplateUpdateAndCreatePath('ApplicationShopBundle:Admin/Product:update.html.twig')
                      ->setPageTitle('page.product');

        return $configuration;
    }

    /**
     * {@inheritdoc}
     */
    protected function grid($manager, $config = array())
    {
        return $this->get('widget_grid_factory')->createGrid(new ProductGrid($manager));
    }

    /**
     * {@inheritdoc}
     */
    protected function form()
    {
        return $this->createForm(new ProductType());
    }
}
