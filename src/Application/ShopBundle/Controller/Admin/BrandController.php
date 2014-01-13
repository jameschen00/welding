<?php
namespace Application\ShopBundle\Controller\Admin;

use Application\AdminBundle\Controller\AbstractAdminController;
use Application\AdminBundle\Controller\Configuration;
use Application\ShopBundle\Form\Type\BrandType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Application\ShopBundle\Grid\Type\BrandType as BrandGrid;

/**
 * Brand administation controller
 *
 * @Route("/shop/brand")
 */
class BrandController extends AbstractAdminController
{
    /**
     * {@inheritdoc}
     */
    protected function getConfiguration()
    {
        $configuration = new Configuration();
        $configuration->setManager('shop_brand');
        $configuration->setPageTitle('page.brand');

        return $configuration;
    }

    /**
     * {@inheritdoc}
     */
    public function grid($manager)
    {
        return $this->get('widget_grid_factory')->createGrid(new BrandGrid($manager));
    }

    /**
     * {@inheritdoc}
     */
    public function form()
    {
        return $this->createForm(new BrandType());
    }
}
