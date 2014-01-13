<?php
namespace Application\ShopBundle\Controller\Admin;

use Application\AdminBundle\Controller\Configuration;
use Application\ShopBundle\Form\Type\PrototypeType;
use Application\ShopBundle\Grid\Type\PrototypeType as PrototypeGrid;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Application\AdminBundle\Controller\AbstractAdminController;

/**
 * Product prototype administration controller
 *
 * @Route("/shop/prototype")
 */
class PrototypeController extends AbstractAdminController
{
    /**
     * {@inheritdoc}
     */
    protected function getConfiguration()
    {
        $configuration = new Configuration();
        $configuration->setManager('shop_prototype');
        $configuration->setPageTitle('page.prototype');

        return $configuration;
    }

    /**
     * {@inheritdoc}
     */
    public function grid($manager)
    {
        return $this->get('widget_grid_factory')->createGrid(new PrototypeGrid($manager));
    }

    /**
     * {@inheritdoc}
     */
    public function form()
    {
        return $this->createForm(new PrototypeType());
    }

}
