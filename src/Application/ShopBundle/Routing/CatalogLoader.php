<?php
namespace Application\ShopBundle\Routing;

use Application\CoreBundle\Helper\TreeHelper;
use Application\CoreBundle\Manager\ManagerFactory;
use Application\ShopBundle\Service\CategoryTreeService;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\Config\Loader\ResolverInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * Catalog router builder
 */
class CatalogLoader implements LoaderInterface
{
    /**
     * @var bool
     */
    private $loaded = false;

    /**
     * @var CategoryTreeService
     */
    private $treeService;

    /**
     * @param CategoryTreeService $treeService
     */
    public function setTreeService(CategoryTreeService $treeService)
    {
        $this->treeService = $treeService;
    }

    /**
     * @param string          $prefix
     * @param RouteCollection $routes
     * @param array           $children
     * @param int             $level
     *
     * @return null
     */
    private function buildRouter($prefix, RouteCollection $routes, $children, $level)
    {
        foreach ($children as $child) {
            $category = $child['data'];
            $slug = trim($category->getSlug(), '/');

            if ($slug) {
                //add category router
                $pattern = $prefix . $slug . '.{_format}';
                $defaults = array(
                    '_controller' => $level == 1 ? 'ApplicationShopBundle:Catalog:index' : 'ApplicationShopBundle:Catalog:products',
                    '_format'     => 'html',
                    'category'    => $category->getId()
                );
                $requirements = array(
                    '_format' => 'html|json'
                );

                $route = new Route($pattern, $defaults);
                $routes->add('category_' . $category->getId(), $route, $requirements);
            }
            if (empty($child['child'])) {
                //add product router
                $pattern = $prefix . $slug . '/{product}.{_format}';
                $defaults = array(
                    '_controller' => 'ApplicationShopBundle:Product:index',
                    'category'    => $category->getId(),
                    '_format'     => 'html'
                );
                $requirements = array(
                    'product' => '[\d\w\-]+',
                    '_format' => 'html|json'
                );
                $route = new Route($pattern, $defaults);
                $routes->add('category_products_' . $category->getId(), $route, $requirements);
            } else {
                $this->buildRouter($prefix . $slug . '/', $routes, $child['child'], $level + 1);
            }
        }
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

        //fetch all categories
        $tree = $this->treeService->getTree();

        //register routers
        $this->buildRouter('/', $routes, $tree->tree()->data, 0);
        $this->loaded = true;

        return $routes;
    }

    /**
     * {@inheritdoc}
     */
    public function supports($resource, $type = null)
    {
        return $type == 'category';
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