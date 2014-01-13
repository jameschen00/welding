<?php
namespace Application\BannerBundle\Controller\Admin;

use Application\AdminBundle\Controller\AbstractAdminController;
use Application\AdminBundle\Controller\Configuration;
use Application\BannerBundle\Form\Type\BannerType;
use \Application\BannerBundle\Grid\Type\BannerType as BannerGrid;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Banner administration controller
 *
 * @Route("/banner")
 */
class BannerController extends AbstractAdminController
{
    /**
     * {@inheritdoc}
     */
    protected function getConfiguration()
    {
        $configuration = new Configuration();
        $configuration->setManager('banner_banner');
        $configuration->setPageTitle('page.banner');
        $configuration->setTemplateUpdateAndCreatePath('ApplicationBannerBundle:Admin/Banner:update.html.twig');

        return $configuration;
    }

    /**
     * {@inheritdoc}
     */
    public function grid($manager)
    {
        return $this->get('widget_grid_factory')->createGrid(new BannerGrid($manager));
    }

    /**
     * {@inheritdoc}
     */
    public function form()
    {
        return $this->createForm(new BannerType());
    }
}
