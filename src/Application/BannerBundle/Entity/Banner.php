<?php
namespace Application\BannerBundle\Entity;

use Application\CoreBundle\Library\Doctrine\ActiveEntityTrait;
use Application\CoreBundle\Library\Doctrine\BaseEntity;
use Application\CoreBundle\Library\Doctrine\ModifyEntityTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Banner
 *
 * @ORM\Table(name="banner_item")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity
 */
class Banner extends BaseEntity
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
     * @Assert\File(maxSize="6000000")
     * @var string
     */
    private $file;

    /**
     * @var string
     */
    private $temp;

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
     * @var \Datetime
     *
     * @ORM\Column(name="start_date", type="datetime", nullable=false)
     *
     * @Assert\NotBlank()
     */
    private $startDate;

    /**
     * @var \Datetime
     *
     * @ORM\Column(name="stop_date", type="datetime", nullable=false)
     *
     * @Assert\NotBlank()
     */
    private $stopDate;

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
     * @param \DateTime $stopDate
     *
     * @return $this
     */
    public function setStopDate(\DateTime $stopDate)
    {
        $this->stopDate = $stopDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getStopDate()
    {
        return $this->stopDate;
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
     * @param \Datetime $startDate
     *
     * @return $this
     */
    public function setStartDate(\Datetime $startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * @return \Datetime
     */
    public function getStartDate()
    {
        return $this->startDate;
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
        return 'public/img/uploads/banners';
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

            //generate code
            $this->code = $this->genereteCode();
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

    /**
     * Generate the html code of banner
     *
     * @return String
     */
    public function genereteCode()
    {
        $parts    = explode('.', $this->getImg());
        $exension = strtolower(array_pop($parts));

        if ($exension == 'swf') {
            $code = '<embed src="/' . $this->getWebPath() . '?url=' . $this->getUrl() . '" quality="high" bgcolor="#FFFFFF"  wmode="transparent" width="' . $this->getPlace()->getWidth() . '" height="' . $this->getPlace()->getHeight() . '" align="" type="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer" />';
        } elseif (in_array($exension, array('jpg', 'jpeg', 'png', 'gif', 'bmp'))) {
            $code = '<a href="' . $this->getUrl() . '">' .
                "\n" . '<img src="/' . $this->getWebPath() . '" width="' . $this->getPlace()->getWidth() . '" height="' . $this->getPlace()->getHeight() . '" alt="' . $this->getName() . '" border="0" />' .
                "\n" . '</a>';
        } else {
            $code = '<a href="' . $this->getUrl() . '"></a>';
        }

        return $code;
    }

    /**
     * @return null|string
     */
    public function __toString()
    {
        return $this->getCode() ? $this->getCode() : '';
    }
}
