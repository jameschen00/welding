<?php
namespace Application\GalleryBundle\Controller\Admin;

use Application\AdminBundle\Controller\AbstractAdminController;
use Application\AdminBundle\Controller\Configuration;
use Application\GalleryBundle\Form\Type\GalleryType;
use \Application\GalleryBundle\Grid\Type\GalleryType as GalleryGrid;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Gallery administration controller
 *
 * @Route("/Gallery")
 */
class GalleryController extends AbstractAdminController
{
    /**
     * {@inheritdoc}
     */
    protected function getConfiguration()
    {
        $configuration = new Configuration();
        $configuration->setManager('gallery_Gallery');
        $configuration->setPageTitle('page.gallery');
        $configuration->setTemplateUpdateAndCreatePath('ApplicationGalleryBundle:Admin/Gallery:update.html.twig');

        return $configuration;
    }

    /**
     * {@inheritdoc}
     */
    public function grid($manager)
    {
        return $this->get('widget_grid_factory')->createGrid(new GalleryGrid($manager));
    }

    /**
     * {@inheritdoc}
     */
    public function form()
    {
        return $this->createForm(new GalleryType());
    }
}
