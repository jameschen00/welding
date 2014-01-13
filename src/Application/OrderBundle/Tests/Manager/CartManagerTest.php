<?php
namespace Application\OrderBundle\Tests\Manager;

use Application\CoreBundle\Library\Test\AbstractApplicationTest;
use Application\OrderBundle\Entity\CartItem;
use Application\OrderBundle\Manager\CartManager;
use Application\OrderBundle\Service\CartService;

/**
 * Test for cart
 */
class CartManagerTest extends AbstractApplicationTest
{
    /**
     * @var CartService
     */
    private $cart;

    /**
     * @var CartManager
     */
    private $manager;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();
        $this->cart = $this->container->get('cart');
        $this->manager = $this->container->get('manager.order.cart');

        //add item to cart
        $item = new CartItem();
        $item->setProductId(1);
        $item->setCount(2);
        $this->cart->add($item);
    }

    /**
     * Add
     */
    public function testProducts()
    {
        $this->assertTrue(count($this->manager->getProducts()) > 0);
    }
}
