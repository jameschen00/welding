<?php
namespace Application\ShopBundle\Entity;

use Application\CoreBundle\Library\Doctrine\ActiveEntityTrait;
use Application\CoreBundle\Library\Doctrine\BaseEntity;
use Application\CoreBundle\Library\Doctrine\MetaTagsEntityTrait;
use Application\CoreBundle\Library\Doctrine\ModifyEntityTrait;
use Application\CoreBundle\Library\Doctrine\OrderingEntityTrait;
use Application\CoreBundle\Library\Doctrine\SlugEntityTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Category
 *
 * @ORM\Table(name="shop_category")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity
 * @Vich\Uploadable
 */
class Category extends BaseEntity
{
    use OrderingEntityTrait;
    use SlugEntityTrait;
    use ModifyEntityTrait;
    use MetaTagsEntityTrait;
    use ActiveEntityTrait;

    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Category", cascade={"persist"}, inversedBy="categories")
     * @ORM\JoinColumn(name="pid", referencedColumnName="id", onDelete="CASCADE")
     */
    private $parent;

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
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=100, nullable=true)
     */
    private $image;

    /**
     * @var Prototype
     *
     * @ORM\ManyToOne(targetEntity="Prototype", cascade={"persist"})
     * @ORM\JoinColumn(name="prototype_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $prototype;

    /**
     * @var Prototype
     *
     * @ORM\OneToMany(targetEntity="Category", mappedBy="parent",  cascade={"persist"})
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="category")
     */
    private $products;

    /**
     * @var UploadedFile
     *
     * @Assert\File(
     *     maxSize="2M",
     *     mimeTypes={"image/png", "image/jpeg", "image/pjpeg"}
     * )
     *
     * @Vich\UploadableField(mapping="shop_category_image", fileNameProperty="image")
     */
    private $file;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->products = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param ArrayCollection $categories
     *
     * @return $this
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set parent category
     *
     * @param Category $category
     *
     * @return $this
     */
    public function setParent(Category $category)
    {
        $this->parent = $category;

        return $this;
    }

    /**
     * Get parent category
     *
     * @return Category
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Get parent category id
     *
     * @return int
     */
    public function getPid()
    {
        return $this->parent ? $this->parent->getId() : 0;
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
     * @param string $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $image
     *
     * @return $this
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @return integer
     */
    public function getCategoryPid()
    {
        return $this->getParent() ? $this->getParent()->getId() : 0;
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
     * Sets file.
     *
     * @param UploadedFile $file
     *
     * @return $this
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;

        //update date
        $this->setUpdatedAtValue();

        return $this;
    }

    /**
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }
}
