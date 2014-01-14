<?php
namespace Application\NewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * News side component
 */
class ComponentController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $manager = $this->get('core_manager_factory')->get('news_news');
        $news = $manager->where()->order()->limit($this->container->getParameter('news_count_block'))->findAll();

        return $this->render('ApplicationNewsBundle:News:component.html.twig', array('news' => $news));
    }
}
