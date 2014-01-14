<?php
namespace Application\NewsBundle\Entity;

use Application\CoreBundle\Library\Doctrine\ActiveEntityTrait;
use Application\CoreBundle\Library\Doctrine\BaseEntity;
use Application\CoreBundle\Library\Doctrine\ModifyEntityTrait;
use Application\CoreBundle\Library\Doctrine\SlugEntityTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Section
 *
 * @ORM\Table(name="news_section")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity
 */
class Section extends BaseEntity
{
    use ModifyEntityTrait;
    use ActiveEntityTrait;
    use SlugEntityTrait;

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
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }
}
