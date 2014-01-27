<?php
namespace Application\NewsBundle\Entity;

use Application\CoreBundle\Library\Doctrine\ActiveEntityTrait;
use Application\CoreBundle\Library\Doctrine\BaseEntity;
use Application\CoreBundle\Library\Doctrine\ModifyEntityTrait;
use Application\CoreBundle\Library\Doctrine\PeriodEntityTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * News
 *
 * @ORM\Table(name="news_item")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity
 * @Vich\Uploadable
 */
class News extends BaseEntity
{
    use ModifyEntityTrait;
    use ActiveEntityTrait;
    use PeriodEntityTrait;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=100, nullable=true)
     *
     * @Assert\NotBlank()
     * @Assert\Length(min = "2", max="100")
     */
    private $title;

    /**
     * @var Section
     *
     * @ORM\ManyToOne(targetEntity="Section", cascade={"persist"})
     * @ORM\JoinColumn(name="section_id", referencedColumnName="id", onDelete="RESTRICT")
     */
    private $section;

    /**
     * @var string
     *
     * @ORM\Column(name="short_text", type="text", nullable=true)
     */
    private $shortText;

    /**
     * @var string
     *
     * @ORM\Column(name="full_text", type="text", nullable=true)
     */
    private $fullText;

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
     * @Vich\UploadableField(mapping="news_item", fileNameProperty="img")
     */
    private $file;

    /**
     * Set title
     *
     * @param string $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
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
     * @param \Application\NewsBundle\Entity\Section $section
     *
     * @return $this
     */
    public function setSection($section)
    {
        $this->section = $section;

        return $this;
    }

    /**
     * @return \Application\NewsBundle\Entity\Section
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * @param string $shortText
     *
     * @return $this
     */
    public function setShortText($shortText)
    {
        $this->shortText = $shortText;

        return $this;
    }

    /**
     * @return string
     */
    public function getShortText()
    {
        return $this->shortText;
    }

    /**
     * @param string $fullText
     *
     * @return $this
     */
    public function setFullText($fullText)
    {
        $this->fullText = $fullText;

        return $this;
    }

    /**
     * @return string
     */
    public function getFullText()
    {
        return $this->fullText;
    }

    /**
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
        return $this->getTitle();
    }
}
