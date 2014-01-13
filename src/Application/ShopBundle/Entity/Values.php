<?php

namespace Application\ShopBundle\Entity;

use Application\CoreBundle\Library\Doctrine\ModifyEntityTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Product property varchar value
 *
 * @ORM\Entity
 * @ORM\Table(name="shop_catalog_textvalues")
 */
class Values
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(name="prop_id", type="integer")
     */
    private $propId;

    /**
     * @ORM\Column(name="product_id", type="integer")
     */
    private $productId;

    /**
     * @ORM\Column(name="value", type="text")
     */
    private $value;

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $productId
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;
    }

    /**
     * @return mixed
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * @param mixed $propId
     */
    public function setPropId($propId)
    {
        $this->propId = $propId;
    }

    /**
     * @return mixed
     */
    public function getPropId()
    {
        return $this->propId;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }


}
