<?php
namespace Application\UserBundle\Controller\Admin;

use Application\AdminBundle\Controller\Configuration;
use Application\UserBundle\Grid\Type\UserType as UserGrid;
use Application\UserBundle\Form\Type\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Application\AdminBundle\Controller\AbstractAdminController;

/**
 * Class UserController
 *
 * @Route("/user")
 */
class UserController extends AbstractAdminController
{
    /**
     * @return Configuration
     */
    protected function getConfiguration()
    {
        $configuration = new Configuration();
        $configuration->setManager('user_user');
        $configuration->setTemplateUpdateAndCreatePath('ApplicationUserBundle:Admin/User:update.html.twig')
                      ->setPageTitle('page.user');

        return $configuration;
    }

    /**
     * {@inheritdoc}
     */
    protected function grid($manager)
    {
        return $this->get('widget_grid_factory')->createGrid(new UserGrid($manager));
    }

    /**
     * {@inheritdoc}
     */
    protected function form()
    {
        return $this->createForm(new UserType());
    }
}
