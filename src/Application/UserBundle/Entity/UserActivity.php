<?php
namespace Application\UserBundle\Entity;

use Application\CoreBundle\Library\Doctrine\BaseEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * UserActivity
 *
 * @ORM\Entity
 * @ORM\Table(name="user_activity")
 */
class UserActivity extends BaseEntity
{
    const ACTIVITY_LOGIN = 'login';

    const ACTIVITY_RESTORE_PASSWORD = 'password';

    const ACTIVITY_REGISTER = 'register';

    const ACTIVITY_ACTIVATE = 'activate';

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="userActivity", cascade={"persist"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=30, nullable=true, name="activity")
     */
    private $activity;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true, name="eventtime")
     */
    private $eventtime;

    /**
     * Set user
     *
     * @param User $user
     *
     * @return $this
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set activity
     *
     * @param string $activity
     *
     * @return $this
     */
    public function setActivity($activity)
    {
        $this->activity = $activity;

        return $this;
    }

    /**
     * Get activity
     *
     * @return string
     */
    public function getActivity()
    {
        return $this->activity;
    }

    /**
     * Set eventtime
     *
     * @param \DateTime $eventtime
     *
     * @return $this
     */
    public function setEventtime($eventtime)
    {
        $this->eventtime = $eventtime;

        return $this;
    }

    /**
     * Get eventtime
     *
     * @return \DateTime
     */
    public function getEventtime()
    {
        return $this->eventtime;
    }
}
