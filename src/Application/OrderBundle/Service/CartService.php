<?php
namespace Application\OrderBundle\Service;
use Application\OrderBundle\Entity\CartItem;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Shopping cart
 */
class CartService
{
    const KEY = 'cart';

    /**
     * @var \Symfony\Component\HttpFoundation\Session\Session
     */
    private $storage;

    /**
     * @param Session $storage
     */
    public function __construct(Session $storage)
    {
        $this->storage = $storage;
    }

    /**
     * Get items form storage
     *
     * @return \ArrayObject
     */
    private function items()
    {
        $items = $this->storage->get(self::KEY);
        if (empty($items)) {
            $items = new \ArrayObject();
        }

        return $items;
    }

    /**
     * Save items to storage
     *
     * @param \ArrayObject $items
     */
    private function flush(\ArrayObject $items)
    {
        $this->storage->set(self::KEY, $items);
    }

    /**
     * Get all product that exist in cart
     *
     * @return array
     */
    public function getList()
    {
        return $this->items();
    }

    /**
     * @param CartItem $item
     */
    public function add(CartItem $item)
    {
        $items = $this->items();
        $items[$item->getId()] = $item;
        $this->flush($items);
    }

    /**
     * @param CartItem $item
     */
    public function remove(CartItem $item)
    {
        $items = $this->items();
        unset($items[$item->getId()]);
        $this->flush($items);
    }

    /**
     * @param int $itemId
     *
     * @return CartItem|bool
     */
    public function getItemById($itemId)
    {
        if ($this->hasItemById($itemId)) {
            $items = $this->items();

            return $items[$itemId];
        }

        return false;
    }

    /**
     * @param CartItem $item
     *
     * @return bool
     */
    public function hasItem($item)
    {
        return $this->hasItemById($item->getId());
    }

    /**
     * @param int $itemId
     *
     * @return bool
     */
    public function hasItemById($itemId)
    {
        $items = $this->items();

        return isset($items[$itemId]);
    }

    /**
     * @param CartItem $item
     *
     * @throws \Exception
     */
    public function change(CartItem $item)
    {
        $items = $this->items();
        if (isset($items[$item->getId()])) {
            $items->{$item->getId()} = $item;
        } else {
            throw new \Exception('Item with id "'.$item->getId().'" does not exist');
        }
        $this->flush($items);
    }

    /**
     * Clear cart
     */
    public function clear()
    {
        $this->flush(new \ArrayObject());
    }
}
