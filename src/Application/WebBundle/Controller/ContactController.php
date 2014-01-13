<?php

namespace Application\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class ContactController
 */
class ContactController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $this->get("white_october_breadcrumbs")->addItem('page.contact.title');

        return $this->render('ApplicationWebBundle:Contact:index.html.twig');
    }
}
