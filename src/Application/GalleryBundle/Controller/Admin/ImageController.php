<?php
namespace Application\GalleryBundle\Controller\Admin;

use Application\AdminBundle\Controller\AbstractAdminController;
use Application\AdminBundle\Controller\Configuration;
use Application\GalleryBundle\Form\Type\ImageType;
use \Application\GalleryBundle\Grid\Type\ImageType as ImageGrid;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Gallery administration controller
 *
 * @Route("/gallery/image")
 */
class ImageController extends AbstractAdminController
{
    /**
     * {@inheritdoc}
     */
    protected function getConfiguration()
    {
        $configuration = new Configuration();
        $configuration->setManager('gallery_image');
        $configuration->setPageTitle('page.gallery.image.title');
        $configuration->setTemplateUpdateAndCreatePath('ApplicationGalleryBundle:Admin/Gallery:update.html.twig');

        return $configuration;
    }

    /**
     * {@inheritdoc}
     */
    public function grid($manager)
    {
        return $this->get('widget_grid_factory')->createGrid(new ImageGrid($manager));
    }

    /**
     * {@inheritdoc}
     */
    public function form()
    {
        return $this->createForm(new ImageType());
    }
}