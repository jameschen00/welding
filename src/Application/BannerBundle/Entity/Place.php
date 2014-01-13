<?php
namespace Application\BannerBundle\Entity;

use Application\CoreBundle\Library\Doctrine\ActiveEntityTrait;
use Application\CoreBundle\Library\Doctrine\BaseEntity;
use Application\CoreBundle\Library\Doctrine\ModifyEntityTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Place
 *
 * @ORM\Table(name="banner_place")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity
 */
class Place extends BaseEntity
{
    use ModifyEntityTrait;
    use ActiveEntityTrait;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=true)
     *
     * @Assert\NotBlank()
     * @Assert\Length(min = "2", max="100")
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="width", type="integer", nullable=false)
     *
     * @Assert\Type(type="numeric")
     */
    private $width;

    /**
     * @var integer
     *
     * @ORM\Column(name="height", type="integer", nullable=false)
     *
     * @Assert\Type(type="numeric")
     */
    private $height;

    /**
     * @var integer
     *
     * @ORM\Column(name="count", type="integer")
     * @Assert\Type(type="numeric")
     */
    private $count;

    /**
     * @var string
     *
     * @ORM\Column(name="bseparator", type="string", length=100, nullable=true)
     */
    private $bseparator;

    /**
     * @var string
     *
     * @ORM\Column(name="scontainer", type="string", length=100, nullable=true)
     */
    private $scontainer;

    /**
     * @var string
     *
     * @ORM\Column(name="econtainer", type="string", length=100, nullable=true)
     */
    private $econtainer;

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Brand
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param int $height
     *
     * @return $this
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param int $width
     *
     * @return $this
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param string $bseparator
     *
     * @return $this
     */
    public function setBseparator($bseparator)
    {
        $this->bseparator = $bseparator;

        return $this;
    }

    /**
     * @return string
     */
    public function getBseparator()
    {
        return $this->bseparator;
    }

    /**
     * @param int $count
     *
     * @return $this
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param string $econtainer
     *
     * @return $this
     */
    public function setEcontainer($econtainer)
    {
        $this->econtainer = $econtainer;

        return $this;
    }

    /**
     * @return string
     */
    public function getEcontainer()
    {
        return $this->econtainer;
    }

    /**
     * @param string $scontainer
     *
     * @return $this
     */
    public function setScontainer($scontainer)
    {
        $this->scontainer = $scontainer;

        return $this;
    }

    /**
     * @return string
     */
    public function getScontainer()
    {
        return $this->scontainer;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }
}
