<?php
namespace Application\OrderBundle\Controller;

use Application\OrderBundle\Entity\CartItem;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Cart controller
 */
class CartController extends Controller
{
    /**
     * View cart
     *
     * @return array
     * @Template()
     */
    public function indexAction()
    {
        return array('products' => $this->get('manager.order.cart')->getProducts());
    }

    /**
     * @return JsonResponse
     */
    public function calculateAction()
    {
        return new JsonResponse(array('success' => true));
    }

    /**
     * Add product to cart
     *
     * @param int $product
     *
     * @return Response
     */
    public function addAction($product)
    {
        $item = new CartItem();
        $item->setProductId($product);
        $item->setCount(1);
        $this->get('cart')->add($item);

        return new JsonResponse(array('success' => true));
    }

    /**
     * Remove product from cart
     *
     * @param int $product
     *
     * @return Response
     */
    public function deleteAction($product)
    {
        if ($item = $this->get('cart')->getItemById($product)) {
            $this->get('cart')->remove($item);
        }

        return new JsonResponse(array('success' => true));
    }

    /**
     * Clear cart
     *
     * @return Response
     */
    public function clearAction()
    {
        $this->get('cart')->clear();

        return new JsonResponse(array('success' => true));
    }
}
