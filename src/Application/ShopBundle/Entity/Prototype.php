<?php
namespace Application\ShopBundle\Entity;

use Application\CoreBundle\Library\Doctrine\BaseEntity;
use Application\CoreBundle\Library\Doctrine\ModifyEntityTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Prototype
 *
 * @ORM\Table(name="shop_prototype")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity
 */
class Prototype extends BaseEntity
{
    use ModifyEntityTrait;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     *
     * @Assert\NotBlank()
     * @Assert\Length(min = "3", max = "100")
     */
    private $name;

    /**
     * @var ArrayCollection $properties
     *
     * @ORM\ManyToMany(targetEntity="Property", cascade={"persist"})
     * @ORM\JoinTable(name="shop_prototype_property",
     *     joinColumns={@ORM\JoinColumn(name="prototype_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="property_id", referencedColumnName="id")}
     * )
     */
    private $properties;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->properties = new ArrayCollection();
    }

    /**
     * @param string $name
     *
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return ArrayCollection
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @param Property $property
     *
     * @return $this
     */
    public function addProperty(Property $property)
    {
        $this->properties->add($property);

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

}
