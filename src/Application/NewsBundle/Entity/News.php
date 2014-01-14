<?php
namespace Application\NewsBundle\Entity;

use Application\CoreBundle\Library\Doctrine\ActiveEntityTrait;
use Application\CoreBundle\Library\Doctrine\BaseEntity;
use Application\CoreBundle\Library\Doctrine\ModifyEntityTrait;
use Application\CoreBundle\Library\Doctrine\PeriodEntityTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * News
 *
 * @ORM\Table(name="news_item")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity
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
     * @Assert\File(maxSize="6000000")
     * @var string
     */
    private $file;

    /**
     * @var string
     */
    private $temp;

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
     * Sets file.
     *
     * @param UploadedFile $file
     *
     * @return $this
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
        // check if we have an old image img
        if (isset($this->img)) {
            // store the old name to delete after the update
            $this->temp = $this->img;
            $this->img  = null;
        } else {
            $this->img = 'initial';
        }

        return $this;
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
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @return null|string
     */
    public function getAbsolutePath()
    {
        return null === $this->img
            ? null
            : $this->getUploadRootDir() . '/' . $this->img;
    }

    /**
     * @return null|string
     */
    public function getWebPath()
    {
        return null === $this->img
            ? null
            : $this->getUploadDir() . '/' . $this->img;
    }

    /**
     * @return string
     */
    protected function getUploadRootDir()
    {
        // the absolute directory img where uploaded
        // documents should be saved
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }

    /**
     * @return string
     */
    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'public/img/uploads/news';
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->getFile()) {
            // do whatever you want to generate a unique name
            $filename  = sha1(uniqid(mt_rand(), true));
            $this->img = $filename . '.' . $this->getFile()->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->getFile()) {
            return;
        }

        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        $this->getFile()->move($this->getUploadRootDir(), $this->img);

        // check if we have an old image
        if (isset($this->temp)) {
            // delete the old image
            unlink($this->getUploadRootDir() . '/' . $this->temp);
            // clear the temp image img
            $this->temp = null;
        }
        $this->file = null;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }
    }
}
