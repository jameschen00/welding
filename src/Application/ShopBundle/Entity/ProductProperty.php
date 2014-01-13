<?php

namespace Application\ShopBundle\Entity;

use Application\CoreBundle\Library\Doctrine\BaseEntity;
use Application\CoreBundle\Library\Doctrine\ModifyEntityTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Product property varchar value
 *
 * @ORM\Entity
 * @ORM\Table(name="shop_product_property")
 * @ORM\InheritanceType("JOINED")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\DiscriminatorColumn(name="data_type", type="string")
 * @ORM\DiscriminatorMap({
 *      "int" = "\Application\ShopBundle\Entity\ProductPropertyInt",
 *      "varchar" = "\Application\ShopBundle\Entity\ProductPropertyVarchar",
 *      "array" = "\Application\ShopBundle\Entity\ProductPropertyArray",
 *      "text" = "\Application\ShopBundle\Entity\ProductPropertyText"
 * })
 */
abstract class ProductProperty extends BaseEntity
{
    use ModifyEntityTrait;

    /**
     * @var Product
     *
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="properties")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $product;

    /**
     * @var Property
     *
     * @ORM\ManyToOne(targetEntity="Property", cascade={"persist"})
     * @ORM\JoinColumn(name="property_id", referencedColumnName="id", onDelete="CASCADE")
     *
     * @Assert\NotBlank()
     * @Assert\Type(type="Application\ShopBundle\Entity\Property")
     */
    private $property;

    /**
     * @param Product $product
     *
     * @return $this
     */
    public function setProduct(Product $product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param Property $property
     *
     * @return $this
     */
    public function setProperty(Property $property)
    {
        $this->property = $property;

        return $this;
    }

    /**
     * @return Property
     */
    public function getProperty()
    {
        return $this->property;
    }
}
