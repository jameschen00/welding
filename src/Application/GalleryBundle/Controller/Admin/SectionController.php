<?php
namespace Application\GalleryBundle\Controller\Admin;

use Application\AdminBundle\Controller\Configuration;
use Application\GalleryBundle\Form\Type\SectionType;
use Application\GalleryBundle\Grid\Type\SectionType as SectionGrid;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Application\AdminBundle\Controller\AbstractAdminController;

/**
 * Place administration controller
 *
 * @Route("/gallery/section")
 */
class SectionController extends AbstractAdminController
{
    /**
     * {@inheritdoc}
     */
    protected function getConfiguration()
    {
        $configuration = new Configuration();
        $configuration->setManager('gallery_section');
        $configuration->setPageTitle('page.gallery.section.title');

        return $configuration;
    }

    /**
     * {@inheritdoc}
     */
    public function grid($manager)
    {
        return $this->get('widget_grid_factory')->createGrid(new SectionGrid($manager));
    }

    /**
     * {@inheritdoc}
     */
    public function form()
    {
        return $this->createForm(new SectionType());
    }
}
