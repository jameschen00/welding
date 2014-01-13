<?php

namespace Application\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Product property varchar value
 *
 * @ORM\Entity
 * @ORM\Table(name="shop_product_property_int")
 */
class ProductPropertyInt extends ProductProperty
{
    /**
     * @var string
     *
     * @ORM\Column(name="value", type="integer", length=11, nullable=true)
     */
    private $value;

    /**
     * @param integer $value
     *
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return integer
     */
    public function getValue()
    {
        return $this->value;
    }

}

