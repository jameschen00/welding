<?php
namespace Application\UserBundle\Tests\Manager;

use Application\CoreBundle\Library\Test\AbstractApplicationTest;
use Application\UserBundle\Manager\PasswordManager;
use Application\UserBundle\Manager\UserManager;
use Application\UserBundle\Entity\User;

/**
 * Restore password functionality
 */
class PasswordAbstractManagerTest extends AbstractApplicationTest
{
    const EMAIL = 'recovery.passwd@password.com';

    /**
     * @var string
     */
    private $hash;

    /**
     * @var object
     */
    private $user;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();

        //create user
        $this->user = new User();
        $this->user->setFirstname('Antoniy');
        $this->user->setLastname('Kasparov');
        $this->user->setEmail(self::EMAIL);
        $this->user->setUserPassword('123456');

        $manager = new UserManager($this->em);
        $manager -> save($this->user);

        //create password recovery hash
        $managerPassword = new PasswordManager($this->container);
        $this->hash = $managerPassword->start(self::EMAIL);
    }

    /**
     * {@inheritdoc}
     */
    public function tearDown()
    {
        parent::tearDown();

        //delete user
        $manager = new UserManager($this->em);
        $manager -> delete($this->user);
    }

    /**
     *  Test first step restore password
     */
    public function testStart()
    {
        $this->assertTrue($this->hash !== false);
    }

    /**
     *  Test check hash
     */
    public function testCheck()
    {
        $managerPassword = new PasswordManager($this->container);
        $user = $managerPassword->check($this->hash);
        $this->assertTrue(!empty($user));
    }

    /**
     * Test change password
     */
    public function testChange()
    {
        $managerPassword = new PasswordManager($this->container);
        if ($managerPassword->check($this->hash)) {
            if ($managerPassword->change($this->hash, '123456')) {
                $this->assertTrue(true);
            }
        }
    }

    /**
     * Test wrong change password
     */
    public function testWrongChange()
    {
        $managerPassword = new PasswordManager($this->container);
        if ($managerPassword->check(md5(uniqid()))) {
            $this->assertTrue(false);
        } else {
            $this->assertTrue(true);
        }
    }
}
