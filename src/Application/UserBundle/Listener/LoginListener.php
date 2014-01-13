<?php
namespace Application\UserBundle\Listener;
use Application\UserBundle\Entity\User;
use Application\UserBundle\Entity\UserActivity;
use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;

use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

/**
 * Login event listener
 * Fix last login time into user
 *
 * Class LoginListener
 * @package Application\AdminBundle\Listener
 */
class LoginListener
{
    /**
     * @var \Doctrine\Bundle\DoctrineBundle\Registry
     */
    protected $doctrine;

    /**
     * @param Doctrine $doctrine
     */
    public function __construct(Doctrine $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @param InteractiveLoginEvent $event
     */
    public function onLogin(InteractiveLoginEvent $event)
    {
        $user = $event->getAuthenticationToken()->getUser();
        /* @var $user User */
        if ($user) {
            //add activity
            $activity = new UserActivity();
            $activity->setActivity(UserActivity::ACTIVITY_LOGIN);
            $activity->setEventtime(new \DateTime());
            $activity->setUser($user);

            $em = $this->doctrine->getManager();
            $em->persist($activity);
            $em->flush();
        }
    }
}
