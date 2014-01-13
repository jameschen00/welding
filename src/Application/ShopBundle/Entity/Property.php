<?php
namespace Application\ShopBundle\Entity;

use Application\CoreBundle\Library\Doctrine\ActiveEntityTrait;
use Application\CoreBundle\Library\Doctrine\BaseEntity;
use Application\CoreBundle\Library\Doctrine\ModifyEntityTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Manager for product properties.
 *
 * @ORM\Table(name="shop_property")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity
 */
class Property extends BaseEntity
{
    use ModifyEntityTrait;
    use ActiveEntityTrait;

    /**
     * Internal name.
     *
     * @var string
     * @ORM\Column(name="name", type="string", length=32, nullable=false)
     *
     * @Assert\NotBlank()
     * @Assert\Length(min = "3", max = "32")
     */
    private $name;

    /**
     * Type.
     *
     * @var string
     * @ORM\Column(name="type", type="string", length=20, nullable=false)
     *
     * @Assert\NotBlank()
     */
    private $type;

    /**
     * Label
     * Displayed to user.
     *
     * @var string
     * @ORM\Column(name="label", type="string", length=100, nullable=false)
     *
     * @Assert\NotBlank()
     * @Assert\Length(min = "3", max = "100")
     */
    private $label;

    /**
     * @var string
     *
     * @ORM\Column(name="data_type", type="string", length=20, nullable=false)
     * @Assert\NotBlank()
     */
    private $dataType = 'varchar';

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="PropertyChoice", mappedBy="property", cascade={"all"}, orphanRemoval=true)
     * @ORM\OrderBy({"ordering" = "ASC"})
     */
    private $choices;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_required", type="boolean", nullable=false)
     *
     * @Assert\Type(type="boolean")
     */
    private $isRequired = false;

    /**
     * @var string
     * @ORM\Column(name="suffix", type="string", length=32)
     *
     * @Assert\Length(min = "3", max = "100")
     */
    private $suffix;

    /**
     * @var string
     * @ORM\Column(name="prefix", type="string", length=32)
     *
     * @Assert\Length(min = "3", max = "100")
     */
    private $prefix;

    /**
     * @var int
     * @ORM\Column(name="ordering", type="integer")
     */
    private $ordering = 0;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->type    = PropertyType::TEXT;
        $this->choices = new ArrayCollection();
    }

    /**
     * @param string $dataType
     *
     * @return $this
     */
    public function setDataType($dataType)
    {
        $this->dataType = $dataType;

        return $this;
    }

    /**
     * @return string
     */
    public function getDataType()
    {
        return $this->dataType;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     *
     * @return $this
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param int $ordering
     *
     * @return $this
     */
    public function setOrdering($ordering)
    {
        $this->ordering = $ordering;

        return $this;
    }

    /**
     * @return int
     */
    public function getOrdering()
    {
        return $this->ordering;
    }

    /**
     * @param string $prefix
     *
     * @return $this
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * @param string $suffix
     *
     * @return $this
     */
    public function setSuffix($suffix)
    {
        $this->suffix = $suffix;

        return $this;
    }

    /**
     * @return string
     */
    public function getSuffix()
    {
        return $this->suffix;
    }


    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getChoices()
    {
        return $this->choices;
    }

    /**
     * @param Collection $choices
     *
     * @return $this
     */
    public function setChoices(Collection $choices)
    {
        $this->choices = $choices;

        return $this;
    }

    /**
     * @param PropertyChoice $value
     *
     * @return $this
     */
    public function addChoice(PropertyChoice $value)
    {
        if (!$this->hasChoice($value)) {
            $value->setProperty($this);
            $this->choices->add($value);
        }

        return $this;
    }

    /**
     * @param PropertyChoice $value
     *
     * @return $this
     */
    public function removeChoice(PropertyChoice $value)
    {
        if ($this->hasChoice($value)) {
            $this->choices->removeElement($value);
        }

        return $this;
    }

    /**
     * @param PropertyChoice $value
     *
     * @return bool
     */
    public function hasChoice(PropertyChoice $value)
    {
        return $this->choices->contains($value);
    }

    /**
     * @param boolean $isRequired
     *
     * @return $this
     */
    public function setIsRequired($isRequired)
    {
        $this->isRequired = $isRequired;

        return $this;
    }

    /**
     * @return boolean
     */
    public function hasIsRequired()
    {
        return $this->isRequired;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }
}
