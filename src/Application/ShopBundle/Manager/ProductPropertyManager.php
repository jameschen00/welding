<?php
namespace Application\ShopBundle\Manager;

use Application\CoreBundle\Manager\AbstractManager;

/**
 * Class ProductManager
 */
class ProductPropertyManager extends AbstractManager
{
    /**
     * @var string
     */
    protected $repositoryName = 'ApplicationShopBundle:ProductProperty';

    /**
     * @var string
     */
    protected $class = '\Application\ShopBundle\Entity\ProductProperty';

    /**
     * @param int|array $product
     *
     * @return $this
     */
    public function setProduct($product)
    {
        empty($product) && $product = 0;
        $this->where(array('e.product IN (:product)' => array('product' => $product)));

        return $this;
    }

    /**
     * @param int|array $property
     *
     * @return $this
     */
    public function setProperty($property)
    {
        empty($property) && $property = 0;
        $this->where(array('e.property IN (:property)' => array('property' => $property)));

        return $this;
    }
}
