<?php
namespace Application\BannerBundle\Entity;

use Application\CoreBundle\Library\Doctrine\ActiveEntityTrait;
use Application\CoreBundle\Library\Doctrine\BaseEntity;
use Application\CoreBundle\Library\Doctrine\ModifyEntityTrait;
use Application\CoreBundle\Library\Doctrine\PeriodEntityTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Banner
 *
 * @ORM\Table(name="banner_item")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity
 * @Vich\Uploadable
 */
class Banner extends BaseEntity
{
    use ModifyEntityTrait;
    use ActiveEntityTrait;
    use PeriodEntityTrait;

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
     * @var Place
     *
     * @ORM\ManyToOne(targetEntity="Place", cascade={"persist"})
     * @ORM\JoinColumn(name="place_id", referencedColumnName="id", onDelete="RESTRICT")
     */
    private $place;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=false)
     *
     * @Assert\NotBlank()
     * @Assert\Length(max="255")
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="text", nullable=true)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="img", type="string", nullable=true)
     */
    private $img;

    /**
     * @var UploadedFile
     *
     * @Assert\File(
     *     maxSize="2M",
     *     mimeTypes={"image/png", "image/jpeg", "image/pjpeg"}
     * )
     *
     * @Vich\UploadableField(mapping="banner_file", fileNameProperty="img")
     */
    private $file;

    /**
     * @var integer
     *
     * @ORM\Column(name="priority", type="integer", nullable=false)
     *
     * @Assert\NotBlank()
     * @Assert\Type(type="numeric")
     */
    private $priority = 500;

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
     * @param string $img
     *
     * @return $this
     */
    public function setImg($img)
    {
        $this->img = $img;

        return $this;
    }

    /**
     * @return string
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * @param \Application\BannerBundle\Entity\Place $place
     *
     * @return $this
     */
    public function setPlace($place)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * @return \Application\BannerBundle\Entity\Place
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * @param int $priority
     *
     * @return $this
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param string $url
     *
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
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
     * @return null|string
     */
    public function __toString()
    {
        return $this->getCode() ? $this->getCode() : '';
    }
}
