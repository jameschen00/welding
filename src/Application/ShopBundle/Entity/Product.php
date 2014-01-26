<?php

namespace Application\ShopBundle\Entity;

use Application\CoreBundle\Library\Doctrine\ActiveEntityTrait;
use Application\CoreBundle\Library\Doctrine\BaseEntity;
use Application\CoreBundle\Library\Doctrine\MetaTagsEntityTrait;
use Application\CoreBundle\Library\Doctrine\ModifyEntityTrait;
use Application\CoreBundle\Library\Doctrine\SlugEntityTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Product entity
 *
 * @ORM\Table(name="shop_product")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity
 */
class Product extends BaseEntity
{
    use SlugEntityTrait;
    use ModifyEntityTrait;
    use MetaTagsEntityTrait;
    use ActiveEntityTrait;

    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Category", cascade={"persist"})
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", onDelete="RESTRICT")
     */
    private $category;

    /**
     * @var Prototype
     *
     * @ORM\ManyToOne(targetEntity="Prototype", cascade={"persist"})
     * @ORM\JoinColumn(name="prototype_id", referencedColumnName="id", onDelete="RESTRICT")
     *
     * @Assert\NotBlank()
     * @Assert\Type(type="Application\ShopBundle\Entity\Prototype")
     */
    private $prototype;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     *
     * @Assert\NotBlank()
     * @Assert\Length(min = "3", max = "255")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="model", type="string", length=100, nullable=true)
     *
     * @Assert\NotBlank()
     * @Assert\Length(min = "3", max = "100")
     */
    private $model;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=100, nullable=true)
     */
    private $code;

    /**
     * @var integer
     *
     * @ORM\Column(name="is_deleted", type="boolean", nullable=false)
     *
     * @Assert\Type(type="boolean")
     */
    private $isDeleted = false;

    /**
     * @var Brand
     *
     * @ORM\ManyToOne(targetEntity="Brand", cascade={"persist"})
     * @ORM\JoinColumn(name="brand_id", referencedColumnName="id", onDelete="RESTRICT")
     */
    private $brand;

    /**
     * @var int
     *
     * @ORM\Column(name="ordering", type="integer")
     *
     * @Assert\Type(type="integer")
     */
    private $ordering = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="short_description", type="text", nullable=true)
     */
    private $shortDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="full_description", type="text", nullable=true)
     */
    private $fullDescription;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="ProductFile", mappedBy="product", cascade={"all"}, orphanRemoval=true)
     * @ORM\OrderBy({"ordering" = "ASC"})
     */
    private $image;

    /**
     * @ORM\ManyToMany(targetEntity="Category", cascade={"persist"})
     * @ORM\JoinTable(name="shop_product_category",
     *     joinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id")}
     * )
     * @var ArrayCollection $categories
     */
    private $categories;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="ProductProperty", mappedBy="product", cascade={"all"})
     */
    private $properties;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->image = new ArrayCollection();
        $this->properties = new ArrayCollection();
    }

    /**
     * Set category
     *
     * @param Category $category
     *
     * @return Product
     */
    public function setCategory(Category $category)
    {
        if ($this->prototype == null) {
            $this->prototype = $category->getPrototype();
        }
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param Prototype $prototype
     *
     * @return $this
     */
    public function setPrototype(Prototype $prototype)
    {
        $this->prototype = $prototype;

        return $this;
    }

    /**
     * @return Prototype
     */
    public function getPrototype()
    {
        return $this->prototype;
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
    public function getName()
    {
        return $this->name;
    }


    /**
     * @param integer $isDeleted
     *
     * @return $this
     */
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    /**
     * @return integer
     */
    public function hasIsDeleted()
    {
        return $this->isDeleted;
    }

    /**
     * @param string $shortDescription
     *
     * @return $this
     */
    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    /**
     * @return string
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    /**
     * @param Brand $brand
     *
     * @return $this
     */
    public function setBrand(Brand $brand)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @return Brand
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @param string $model
     *
     * @return $this
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param string $code
     *
     * @return $this
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
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
     * @param string $fullDescription
     *
     * @return $this
     */
    public function setFullDescription($fullDescription)
    {
        $this->fullDescription = $fullDescription;

        return $this;
    }

    /**
     * @return string
     */
    public function getFullDescription()
    {
        return $this->fullDescription;
    }

    /**
     * @param ProductFile $image
     *
     * @return $this
     */
    public function addImage(ProductFile $image)
    {
        $image->setProduct($this);
        $this->image->add($image);

        return $this;
    }

    /**
     * @param ProductFile $image
     */
    public function removeImage(ProductFile $image)
    {
        $this->image->removeElement($image);
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @return ArrayCollection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param ArrayCollection $properties
     *
     * @return $this
     */
    public function setProperties(ArrayCollection $properties)
    {
        $this->properties = $properties;

        return $this;
    }

    /**
     * @param ProductProperty $property
     *
     * @return $this
     */
    public function addProperty(ProductProperty $property)
    {
        if (!$this->hasProperty($property)) {
            $property->setProduct($this);
            $this->properties->add($property);
        }

        return $this;
    }

    /**
     * @param ProductProperty $property
     *
     * @return $this
     */
    public function removeProperty(ProductProperty $property)
    {
        if ($this->hasProperty($property)) {
            $this->properties->removeElement($property);
        }

        return $this;
    }

    /**
     * @param ProductProperty $property
     *
     * @return bool
     */
    public function hasProperty(ProductProperty $property)
    {
        return $this->properties->contains($property);
    }

    /**
     * @return ArrayCollection
     */
    public function getProperties()
    {
        return $this->properties;
    }
}
