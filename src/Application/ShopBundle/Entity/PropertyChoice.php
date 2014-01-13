<?php

namespace Application\ShopBundle\Entity;

use Application\CoreBundle\Library\Doctrine\BaseEntity;
use Application\CoreBundle\Library\Doctrine\ModifyEntityTrait;
use Application\CoreBundle\Library\Doctrine\OrderingEntityTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Manager for choices of product properties
 *
 * @ORM\Table(name="shop_property_choice")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity
 */
class PropertyChoice extends BaseEntity
{
    use OrderingEntityTrait;
    use ModifyEntityTrait;

    /**
     * @var Property
     *
     * @ORM\ManyToOne(targetEntity="Property", inversedBy="choices")
     * @ORM\JoinColumn(name="property_id", referencedColumnName="id")
     */
    private $property;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=100, nullable=false)
     *
     * @Assert\NotBlank()
     * @Assert\Length(max = "100")
     */
    private $value;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->value;
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

    /**
     * @param string $value
     *
     * @return $this;
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param int $valueId
     *
     * @return $this
     */
    public function setValueId($valueId)
    {
        $this->valueId = $valueId;

        return $this;
    }
}
