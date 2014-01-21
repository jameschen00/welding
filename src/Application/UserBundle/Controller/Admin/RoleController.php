<?php
namespace Application\UserBundle\Controller\Admin;

use Application\AdminBundle\Controller\Configuration;
use Application\UserBundle\Grid\Type\RoleType as RoleGrid;
use Application\UserBundle\Form\Type\RoleType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Application\AdminBundle\Controller\AbstractAdminController;

/**
 * Class RoleController
 *
 * @Route("/role")
 */
class RoleController extends AbstractAdminController
{
    /**
     * @return Configuration
     */
    protected function getConfiguration()
    {
        $configuration = new Configuration();
        $configuration->setManager('user_role');
        $configuration->setPageTitle('page.role.title');

        return $configuration;
    }

    /**
     * {@inheritdoc}
     */
    protected function grid($manager)
    {
        return $this->get('widget_grid_factory')->createGrid(new RoleGrid($manager));
    }

    /**
     * {@inheritdoc}
     */
    protected function form()
    {
        return $this->createForm(new RoleType());
    }
}
