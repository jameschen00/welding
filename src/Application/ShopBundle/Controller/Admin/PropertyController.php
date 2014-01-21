<?php
namespace Application\ShopBundle\Controller\Admin;

use Application\AdminBundle\Controller\Configuration;
use Application\ShopBundle\Form\Type\PropertyType;
use Application\ShopBundle\Grid\Type\PropertyType as PropertyGrid;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Application\AdminBundle\Controller\AbstractAdminController;

/**
 * Propery administration class
 *
 * @Route("/shop/property")
 */
class PropertyController extends AbstractAdminController
{
    /**
     * {@inheritdoc}
     */
    protected function getConfiguration()
    {
        $configuration = new Configuration();
        $configuration->setManager('shop_property');
        $configuration->setTemplateUpdateAndCreatePath('ApplicationShopBundle:Admin/Property:update.html.twig')
                      ->setPageTitle('page.property');

        return $configuration;
    }

    /**
     * {@inheritdoc}
     */
    protected function grid($manager)
    {
        return $this->get('widget_grid_factory')->createGrid(new PropertyGrid($manager));
    }

    /**
     * {@inheritdoc}
     */
    protected function form()
    {
        return $this->createForm(new PropertyType());
    }
}
