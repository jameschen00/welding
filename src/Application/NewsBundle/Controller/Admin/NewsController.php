<?php
namespace Application\NewsBundle\Controller\Admin;

use Application\AdminBundle\Controller\AbstractAdminController;
use Application\AdminBundle\Controller\Configuration;
use Application\NewsBundle\Form\Type\NewsType;
use \Application\NewsBundle\Grid\Type\NewsType as NewsGrid;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * News administration controller
 *
 * @Route("/news/news")
 */
class NewsController extends AbstractAdminController
{
    /**
     * {@inheritdoc}
     */
    protected function getConfiguration()
    {
        $configuration = new Configuration();
        $configuration->setManager('news_news');
        $configuration->setPageTitle('page.news.news.title');
        $configuration->setTemplateUpdateAndCreatePath('ApplicationNewsBundle:Admin/News:update.html.twig');

        return $configuration;
    }

    /**
     * {@inheritdoc}
     */
    public function grid($manager)
    {
        return $this->get('widget_grid_factory')->createGrid(new NewsGrid($manager));
    }

    /**
     * {@inheritdoc}
     */
    public function form()
    {
        return $this->createForm(new NewsType());
    }
}
