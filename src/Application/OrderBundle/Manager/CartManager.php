<?php
namespace Application\OrderBundle\Manager;

use Application\CoreBundle\Library\Manager\Doctrine;
use Application\OrderBundle\Entity\CartItem;
use Application\OrderBundle\Entity\Order;
use Application\OrderBundle\Service\CartService;
use Application\ShopBundle\Manager\ProductManager;

/**
 * Class CartManager
 */
class CartManager
{
    /**
     * @var \Application\OrderBundle\Service\CartService
     */
    private $cart;

    /**
     * @var \Application\ShopBundle\Manager\ProductManager
     */
    private $productManager;

    /**
     * @param CartService    $cart
     * @param ProductManager $productManager
     */
    public function __construct(CartService $cart, ProductManager $productManager)
    {
        $this->cart = $cart;
        $this->productManager = $productManager;
    }

    /**
     * @return array
     */
    public function getProducts()
    {
        $items = $this->cart->getList();

        $products = array();
        foreach ($items as $item) {
            $this->productManager->clear();
            $this->productManager->setId($item->getId());
            $products[] = $this->productManager->findOne();
        }

        return $products;
    }
}
