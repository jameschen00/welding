<?php

namespace Application\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class GalleryController
 */
class GalleryController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $managerImage = $this->get('core_manager_factory')->get('gallery_image');
        $images = $managerImage->where()->order()->findAll();

        $managerSection = $this->get('core_manager_factory')->get('gallery_section');
        $sections = $managerSection->where()->order()->findAll();

        $id = $request->query->get('id');

        //crumbs
        $this->get("white_october_breadcrumbs")->addItem('page.gallery.title');

        //render
        return $this->render('ApplicationWebBundle:Gallery:index.html.twig', array(
            'images'   => $images,
            'sections' => $sections,
            'selected' => $id
        ));
    }
}
