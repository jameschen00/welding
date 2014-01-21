<?php
namespace Application\ShopBundle\Controller\Admin;

use Application\AdminBundle\Controller\Configuration;
use Application\ShopBundle\Form\Type\CategoryType;
use Application\ShopBundle\Grid\Type\CategoryType as CategoryGrid;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Application\AdminBundle\Controller\AbstractAdminController;

/**
 * Category administration controller
 *
 * @Route("/shop/category")
 */
class CategoryController extends AbstractAdminController
{
    /**
     * {@inheritdoc}
     */
    protected function getConfiguration()
    {
        $configuration = new Configuration();
        $configuration->setManager('shop_category');
        $configuration->setPageTitle('page.category');

        return $configuration;
    }

    /**
     * {@inheritdoc}
     */
    protected function grid($manager)
    {
        return $this->get('widget_grid_factory')->createGrid(new CategoryGrid($manager), 'tree');
    }

    /**
     * {@inheritdoc}
     */
    protected function form()
    {
        return $this->createForm(new CategoryType());
    }

}
