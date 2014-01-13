<?php
namespace Application\UserBundle\Controller;

use Application\ShopBundle\Manager\CategoryManager;
use Application\ShopBundle\Manager\ProductManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends Controller
{
    /**
     * @param integer $category
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function categoryAction($category)
    {
        $url = explode('/', trim($category, '/'));

        $managerCategory = new CategoryManager($this->getDoctrine()->getManager());
        $managerCategory->findBySlug(end($url));
        $managerCategory->where();
        $category = $managerCategory->findOne();
        if (empty($category)) {
            throw $this->createNotFoundException('The category does not exist');
        }

        //get list of products
        $manager = new ProductManager($this->getDoctrine()->getManager());
        $manager->findByCategoryId($category->getId());
        $manager->where();
        $manager->order();
        $products = $manager->findAll();

        return $this->render('ShopBundle:Default:category.html.php', array('products' => $products, 'category' => $category));
    }

    /**
     * @param integer $category
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function productAction($category, $product)
    {
        $url = explode('/', trim($category, '/'));

        $managerCategory = new CategoryManager($this->getDoctrine()->getManager());
        $managerCategory->findBySlug(end($url));
        $managerCategory->where();
        $category = $managerCategory->findOne();
        if (empty($category)) {
            throw $this->createNotFoundException('The category does not exist');
        }

        //get product
        $manager = new ProductManager($this->getDoctrine()->getManager());
        $manager->findByCategoryId($category->getId());
        $manager->findBySlug($product);
        $manager->where();
        $manager->order();
        $product = $manager->findOne();
        if (empty($product)) {
            return new Response('The product does not exist', 404);
        }

        return $this->render('ShopBundle:Default:product.html.php', array('category' => $category, 'product' => $product));
    }
}
