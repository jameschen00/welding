<?php
namespace Application\GalleryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Gallery side component
 */
class ComponentController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $manager = $this->get('core_manager_factory')->get('gallery_image');
        $images = $manager->where()->selectRandom(8)->findAll();
        shuffle($images);

        return $this->render('ApplicationGalleryBundle:Gallery:component.html.twig', array('images' => $images));
    }
}
