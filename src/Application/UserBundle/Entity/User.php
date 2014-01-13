<?php
namespace Application\UserBundle\Entity;

use Application\CoreBundle\Library\Doctrine\ActiveEntityTrait;
use Application\CoreBundle\Library\Doctrine\BaseEntity;
use Application\CoreBundle\Library\Doctrine\ModifyEntityTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User entity
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="user")
 */
class User extends BaseEntity implements UserInterface
{
    use ModifyEntityTrait;
    use ActiveEntityTrait;

    /**
     * @ORM\Column(type="string", length=100, nullable=false, name="firstname")
     *
     * @var string $firstname
     *
     * @Assert\NotBlank()
     * @Assert\Length(min="1", max="100")
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=100, nullable=false, name="lastname")
     *
     * @var string $lastname
     *
     * @Assert\NotBlank()
     * @Assert\Length(min="1", max="100")
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=100, unique=true, nullable=false, name="email")
     *
     * @var string email
     *
     * @Assert\NotBlank()
     * @Assert\Length(min="5", max="100")
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=false, name="password")
     *
     * @var string password
     * @Assert\NotBlank()
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, name="salt")
     *
     * @var string salt
     */
    private $salt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, name="code")
     *
     * @var string code
     */
    private $code;

    /**
     * @ORM\ManyToMany(targetEntity="Application\UserBundle\Entity\Role")
     * @ORM\JoinTable(
     *     name="user_role",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id", onDelete="CASCADE")}
     * )
     *
     * @var ArrayCollection $userRoles
     */
    private $userRoles;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="UserActivity", mappedBy="user", cascade={"persist"})
     */
    private $userActivity;

    /**
     * @param string $firstname
     *
     * @return $this
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param string $lastname
     *
     * @return $this
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @return string The email.
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $value The email.
     *
     * @return $this
     */
    public function setEmail($value)
    {
        $this->email = $value;

        return $this;
    }

    /**
     * @return string The password.
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $value The password.
     *
     * @return $this
     */
    public function setPassword($value)
    {
        $this->password = $value;

        return $this;
    }

    /**
     * @return string The salt.
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @param string $value The salt.
     *
     * @return $this
     */
    public function setSalt($value)
    {
        $this->salt = $value;

        return $this;
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
     * @return ArrayCollection A Doctrine ArrayCollection
     */
    public function getUserRoles()
    {
        return $this->userRoles;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles()
    {
        $roles = array();
        foreach ($this->userRoles as $role) {
            $roles[] = $role->getRole();
        }

        return $roles;
    }

    /**
     * {@inheritdoc}
     */
    public function setRoles($roles)
    {
        $this->userRoles = $roles;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->userRoles    = new ArrayCollection();
        $this->userActivity = new ArrayCollection();
        $this->salt         = md5(uniqid(time(), true));
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function getUsername()
    {
        return $this->getEmail();
    }

    /**
     * {@inheritdoc}
     */
    public function setUsername($rr)
    {
        return $this->setEmail($rr);
    }

    /**
     * Set user password
     *
     * @param string $password
     *
     * @return $this
     */
    public function setUserPassword($password)
    {
        if ($password) {
            $encoder  = new MessageDigestPasswordEncoder('sha512', true, 10);
            $password = $encoder->encodePassword($password, $this->getSalt());
            $this->setPassword($password);
        }

        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getUserActivity()
    {
        return $this->userActivity;
    }

    /**
     * @return null
     */
    public function getUserPassword()
    {
        return null;
    }
}
