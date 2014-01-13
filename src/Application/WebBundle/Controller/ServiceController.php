<?php

namespace Application\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class ServiceController
 */
class ServiceController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $this->get("white_october_breadcrumbs")->addItem('page.service.title');

        return $this->render('ApplicationWebBundle:Service:index.html.twig');
    }
}
