<?php
namespace Application\UserBundle\Manager;

use Application\CoreBundle\Helper\RequestHelper;
use Application\UserBundle\Entity\UserActivity;

/**
 * Restore password functionality
 *
 * @package Application\UserBundle\Manager
 */
class PasswordManager
{
    /**
     * Path email template
     * @var string
     */
    private $template = 'ApplicationUserBundle:Email:restore.html.twig';

    /**
     * @var \Symfony\Component\DependencyInjection\Container
     */
    protected $container;

    /**
     * @param \Symfony\Component\DependencyInjection\Container $container
     */
    public function __construct(\Symfony\Component\DependencyInjection\Container $container = null)
    {
        $this->container = $container;
    }

    /**
     * Send email to user with restore link
     *
     * @param string $email
     *
     * @return boolean|string
     */
    public function start($email)
    {
        //get user by email
        $userManager = new UserManager($this->container->get('doctrine')->getManager());
        $userManager->findByEmail($email);
        $user = $userManager->findOne();

        if (empty($user)) {
            return false;
        }

        //generate code
        $user->setCode(md5(uniqid(time(), true)));
        $userManager->save($user);

        //generate hash
        $requestHelper = new RequestHelper();
        $requestHelper->addParam('email', $email);
        $requestHelper->addParam('code', $user->getCode());
        $hash = $requestHelper->encode();

        //send message
        try {
            $message = \Swift_Message::newInstance()
                ->setSubject($this->container->get('translator')->trans('page.restore.email.subject'))
                ->setFrom('send@example.com')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->container->get('templating')->render($this->template, array('user' => $user, 'hash' => $hash)),
                    'text/html'
                );
            $this->container->get('mailer')->send($message);
        } catch (\Exception $e) {
            return false;
        }

        return $hash;
    }

    /**
     * Check code
     *
     * @param string $hash
     *
     * @return User
     */
    public function check($hash)
    {
        //generate hash
        $requestHelper = new RequestHelper();
        $requestHelper->decode($hash);

        //get user by email
        $userManager = new UserManager($this->container->get('doctrine')->getManager());
        $userManager->findByEmail($requestHelper->getParam('email'));
        $userManager->findByCode($requestHelper->getParam('code'));
        $user = $userManager->findOne();

        return $user;
    }

    /**
     * Change password
     *
     * @param string $hash
     * @param string $password
     *
     * @return boolean
     */
    public function change($hash, $password)
    {
        $user = $this->check($hash, $password);
        if ($user) {
            $user->setUserPassword($password);
            $user->setCode('');
            $userManager = new UserManager($this->container->get('doctrine')->getManager());
            $userManager->save($user);

            //add activity
            $activity = new UserActivity();
            $activity->setActivity(UserActivity::ACTIVITY_RESTORE_PASSWORD);
            $activity->setEventtime(new \DateTime());
            $activity->setUser($user);
            $user->getUserActivity()->add($activity);

            $userManager->save($user);

            return true;
        }

        return false;
    }
}
