<?php
namespace Application\NewsBundle\Routing;

use Application\CoreBundle\Manager\ManagerFactory;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\Config\Loader\ResolverInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * Catalog router builder
 */
class NewsLoader implements LoaderInterface
{
    /**
     * @var bool
     */
    private $loaded = false;

    /**
     * @var ManagerFactory
     */
    private $managerFactory;

    /**
     * @param ManagerFactory $factory
     */
    public function setManagerFactory(ManagerFactory $factory)
    {
        $this->managerFactory = $factory;
    }

    /**
     * {@inheritdoc}
     */
    public function load($resource, $type = null)
    {
        if (true === $this->loaded) {
            throw new \RuntimeException('Do not add the "extra" loader twice');
        }

        $routes = new RouteCollection();

        //get sections
        $manager  = $this->managerFactory->get('news_section');
        $sections = $manager->where()->order()->findAll();

        //register routers
        foreach ($sections as $section) {
            //add category router
            $pattern      = '/' . $section->getSlug() . '.{_format}';
            $defaults     = array(
                '_controller' => 'ApplicationNewsBundle:News:index',
                '_format'     => 'html',
                'section'     => $section->getId()
            );
            $requirements = array(
                '_format' => 'html|json'
            );

            $route = new Route($pattern, $defaults);
            $routes->add('news_section_' . $section->getId(), $route, $requirements);

            //news item
            $pattern      = '/' . $section->getSlug() . '/{id}.html';
            $defaults     = array(
                '_controller' => 'ApplicationNewsBundle:News:item',
                'section'    => $section->getId(),
            );
            $requirements = array(
                'id'      => '[\d\w\-]+',
            );

            $route = new Route($pattern, $defaults);
            $routes->add('news_item_' . $section->getId(), $route, $requirements);
        }

        $this->loaded = true;

        return $routes;
    }

    /**
     * {@inheritdoc}
     */
    public function supports($resource, $type = null)
    {
        return $type == 'news';
    }

    /**
     * {@inheritdoc}
     */
    public function getResolver()
    {
        // needed, but can be blank, unless you want to load other resources
        // and if you do, using the Loader base class is easier (see below)
    }

    /**
     * {@inheritdoc}
     */
    public function setResolver(LoaderResolverInterface $resolver)
    {
        // same as above
    }
}