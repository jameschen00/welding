<?php

namespace Application\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class PartnerController
 */
class PartnerController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $this->get("white_october_breadcrumbs")->addItem('page.partner.title');

        return $this->render('ApplicationWebBundle:Partner:index.html.twig');
    }
}
