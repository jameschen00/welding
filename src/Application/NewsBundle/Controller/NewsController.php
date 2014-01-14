<?php
namespace Application\NewsBundle\Controller;

use Application\CoreBundle\Library\Pagination\Adapter\ManagerAdapter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class NewsController
 */
class NewsController extends Controller
{
    /**
     * @param int $section
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function indexAction($section)
    {
        $managerSection = $this->get('core_manager_factory')->get('news_section');
        $managerSection->setId($section);
        $managerSection->where();
        $section = $managerSection->findOne();
        if (empty($section)) {
            throw $this->createNotFoundException('The section does not exist');
        }

        //get list
        $manager = $this->get('core_manager_factory')->get('news_news');
        $manager->setSection($section);

        //pagination
        /* @var $paginator Paginator */
        $paginator = $this->get('core_paginator');
        $paginator->setAdapter(new ManagerAdapter($manager));
        $paginator->setPage($this->container->get('request')->get('page', 1));

        $news = $paginator->getItemsByPage();

        //crumbs
        $this->get("white_october_breadcrumbs")->addItem($section->getName());

        //render
        return $this->render('ApplicationNewsBundle:News:index.html.twig', array(
            'news'      => $news,
            'section'   => $section,
            'paginator' => $paginator->render()
        ));
    }


    /**
     * @param int $section
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function itemAction($section, $id)
    {
        $managerSection = $this->get('core_manager_factory')->get('news_section');
        $managerSection->setId($section);
        $managerSection->where();
        $section = $managerSection->findOne();
        if (empty($section)) {
            throw $this->createNotFoundException('The section does not exist');
        }

        //get item
        $manager = $this->get('core_manager_factory')->get('news_news');
        $manager->setSection($section);
        $manager->setId($id);
        $manager->where();
        $item = $manager->findOne();

        //crumbs
        $crumbs = $this->get("white_october_breadcrumbs");
        $crumbs->addItem($section->getName(), $this->get('router')->generate('news_section_' . $section->getId()));
        $crumbs->addItem($item->getTitle());
        
        //render
        return $this->render('ApplicationNewsBundle:News:item.html.twig', array(
            'item' => $item
        ));
    }
}
