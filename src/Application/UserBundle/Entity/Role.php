<?php
namespace Application\UserBundle\Entity;

use Application\CoreBundle\Library\Doctrine\ActiveEntityTrait;
use Application\CoreBundle\Library\Doctrine\BaseEntity;
use Application\CoreBundle\Library\Doctrine\ModifyEntityTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\Role\RoleInterface;

/**
 * Entity for user roles
 *
 * @ORM\Table(name="role")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity
 */
class Role extends BaseEntity implements RoleInterface
{
    use ModifyEntityTrait;
    use ActiveEntityTrait;

    /**
     * @ORM\Column(type="string", length=32, nullable=true, name="name")
     *
     * @var string $name
     *
     * @Assert\NotBlank()
     * @Assert\Length(min="3", max="32")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, name="description")
     *
     * @var string $name
     *
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @return string The name.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setName($value)
    {
        $this->name = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getRole()
    {
        return $this->getName();
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
}
