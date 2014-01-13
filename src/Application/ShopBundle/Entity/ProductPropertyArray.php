<?php

namespace Application\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Product property array value
 *
 * @ORM\Entity
 * @ORM\Table(name="shop_product_property_array")
 */
class ProductPropertyArray extends ProductProperty
{
    /**
     * @var string
     *
     * @ORM\Column(name="value", type="simple_array", nullable=true)
     */
    private $value;

    /**
     * @param Array $value
     *
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return Array
     */
    public function getValue()
    {
        return $this->value != null ? (array) $this->value : null;
    }
}

