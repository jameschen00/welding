<?php
namespace Application\OrderBundle\Tests\Service;

use Application\CoreBundle\Library\Test\AbstractApplicationTest;
use Application\OrderBundle\Entity\CartItem;
use Application\OrderBundle\Service\CartService;

/**
 * Test for cart
 */
class CartServiceTest extends AbstractApplicationTest
{
    /**
     * @var CartService
     */
    private $cart;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();
        $this->cart = $this->container->get('cart');

        //add item to cart
        $item = new CartItem();
        $item->setProductId(1);
        $item->setCount(2);
        $this->cart->add($item);
    }

    /**
     * Add
     */
    public function testAdd()
    {
        $this->assertTrue($this->cart->hasItemById(1));
    }

    /**
     * Remove
     */
    public function testRemove()
    {
        //get item
        $item = $this->cart->getItemById(1);

        //remove item
        $this->cart->remove($item);

        //assert
        $this->assertFalse($this->cart->hasItem($item));
    }

    /**
     * change
     */
    public function testChange()
    {
        $item = $this->cart->getItemById(1);
        $item -> setCount(20);
        $this->cart->change($item);

        $this->assertTrue($this->cart->getItemById(1)->getCount() == 20);
    }

    /**
     *  list
     */
    public function testList()
    {
        $this->assertTrue(count($this->cart->getList()) > 0);
    }

    /**
     *  Clear cart
     */
    public function testClear()
    {
        $this->cart->clear();
        $this->assertTrue(count($this->cart->getList()) == 0);
    }
}
