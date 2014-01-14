<?php
namespace Application\NewsBundle\Controller\Admin;

use Application\AdminBundle\Controller\Configuration;
use Application\AdminBundle\Grid\AdminGridBuilder;
use Application\NewsBundle\Form\Type\PlaceType;
use \Application\NewsBundle\Grid\Type\PlaceType as PlaceGrid;
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
    public function grid($manager)
    {
        return $this->get('widget_grid_factory')->createGrid(new PlaceGrid($manager));
    }

    /**
     * {@inheritdoc}
     */
    public function form()
    {
        return $this->createForm(new PlaceType());
    }
}
