<?php
namespace Application\NewsBundle\Controller\Admin;

use Application\AdminBundle\Controller\Configuration;
use Application\AdminBundle\Grid\AdminGridBuilder;
use Application\NewsBundle\Form\Type\SectionType;
use \Application\NewsBundle\Grid\Type\SectionType as SectionGrid;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Application\AdminBundle\Controller\AbstractAdminController;

/**
 * Place administration controller
 *
 * @Route("/news/section")
 */
class SectionController extends AbstractAdminController
{
    /**
     * {@inheritdoc}
     */
    protected function getConfiguration()
    {
        $configuration = new Configuration();
        $configuration->setManager('news_section');
        $configuration->setPageTitle('page.news.section.title');

        return $configuration;
    }

    /**
     * {@inheritdoc}
     */
    protected function grid($manager)
    {
        return $this->get('widget_grid_factory')->createGrid(new SectionGrid($manager));
    }

    /**
     * {@inheritdoc}
     */
    protected function form()
    {
        return $this->createForm(new SectionType());
    }
}
