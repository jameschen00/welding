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

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function ritmoAction()
    {
        $this->get("white_october_breadcrumbs")->addItem('page.partner.title', $this->generateUrl('web_partners'))->addItem('page.partner.ritmo.title');

        return $this->render('ApplicationWebBundle:Partner:ritmo.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function mempexAction()
    {
        $this->get("white_october_breadcrumbs")->addItem('page.partner.title', $this->generateUrl('web_partners'))->addItem('page.partner.mempex.title');

        return $this->render('ApplicationWebBundle:Partner:mempex.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function centerplasticAction()
    {
        $this->get("white_october_breadcrumbs")->addItem('page.partner.title', $this->generateUrl('web_partners'))->addItem('page.partner.centerplastic.title');

        return $this->render('ApplicationWebBundle:Partner:centerplastic.html.twig');
    }
}
